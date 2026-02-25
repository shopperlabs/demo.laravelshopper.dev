<?php

declare(strict_types=1);

namespace App\Livewire\Checkout;

use App\CheckoutSession;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Validate;
use Shopper\Core\Models\Carrier;
use Shopper\Core\Models\CarrierOption;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\Zone;
use Shopper\Shipping\DataTransferObjects\Address;
use Shopper\Shipping\DataTransferObjects\Package;
use Shopper\Shipping\DataTransferObjects\ShippingRate;
use Shopper\Shipping\Services\CarrierRateService;
use Spatie\LivewireWizard\Components\StepComponent;
use Throwable;

final class Delivery extends StepComponent
{
    public const int CACHE_TTL = 7200;

    /** @var array<int, array<string, mixed>> */
    public array $options = [];

    #[Validate('required', message: 'You must select a delivery method')]
    public string|int|null $currentSelected = null;

    public function mount(): void
    {
        $shippingAddress = session()->get(CheckoutSession::SHIPPING_ADDRESS);
        $countryId = data_get($shippingAddress, 'country_id');
        $shippingOption = session()->get(CheckoutSession::SHIPPING_OPTION);
        $this->currentSelected = $shippingOption ? $shippingOption[0]['id'] : null;

        if (! $countryId || ! $shippingAddress) {
            return;
        }

        $zone = Cache::remember(
            "shipping_zone_country_{$countryId}",
            self::CACHE_TTL,
            fn () => Zone::query()
                ->whereHas('countries', fn ($q) => $q->where('id', $countryId))
                ->where('is_enabled', true)
                ->first(),
        );

        if (! $zone) {
            return;
        }

        $this->options = Cache::remember(
            "shipping_rates_zone_{$zone->id}",
            self::CACHE_TTL,
            fn (): array => $this->fetchRates($zone, $shippingAddress),
        );
    }

    public function save(): void
    {
        $this->validate();

        $selectedOption = collect($this->options)
            ->first(fn (array $option): bool => $option['service_code'] === $this->currentSelected);

        if (! $selectedOption) {
            return;
        }

        session()->forget(CheckoutSession::SHIPPING_OPTION);

        session()->push(CheckoutSession::SHIPPING_OPTION, [
            'id' => $selectedOption['service_code'],
            'name' => $selectedOption['service_name'],
            'price' => $selectedOption['amount'] / 100,
            'service_code' => $selectedOption['service_code'],
            'carrier_code' => $selectedOption['carrier_code'],
            'currency' => $selectedOption['currency'],
            'estimated_days' => $selectedOption['estimated_days'],
        ]);

        $this->dispatch('cart-price-update');

        $this->nextStep();
    }

    public function stepInfo(): array
    {
        return [
            'label' => __('Delivery method'),
            'complete' => session()->exists(CheckoutSession::KEY)
                && session()->get(CheckoutSession::SHIPPING_OPTION) !== null,
        ];
    }

    public function render(): View
    {
        return view('livewire.checkout.delivery');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetchRates(Zone $zone, array $shippingAddress): array
    {
        $service = resolve(CarrierRateService::class);

        try {
            $rates = $service->getRatesForZone(
                zone: $zone,
                from: $this->buildOriginAddress(),
                to: $this->buildDestinationAddress($shippingAddress),
                packages: $this->buildPackages(),
            );
        } catch (Throwable $e) {
            report($e);

            return [];
        }

        return $this->mapRatesToArray($rates, $zone, $service);
    }

    /**
     * @param  Collection<int, ShippingRate>  $rates
     * @return array<int, array<string, mixed>>
     */
    private function mapRatesToArray(Collection $rates, Zone $zone, CarrierRateService $service): array
    {
        $carriers = $zone->carriers()
            ->where('is_enabled', true)
            ->get()
            ->keyBy(fn (Carrier $carrier): string => $carrier->slug ?? $carrier->name);

        $carrierOptions = $zone->shippingOptions()
            ->where('is_enabled', true)
            ->get()
            ->keyBy('id');

        return $rates->map(function (ShippingRate $rate) use ($carriers, $carrierOptions, $service): array {
            /** @var Carrier $carrier */
            $carrier = $carriers->get($rate->carrierCode);
            /** @var ?CarrierOption $option */
            $option = is_int($rate->serviceCode) ? $carrierOptions->get($rate->serviceCode) : null;

            return [
                'service_code' => $rate->serviceCode,
                'service_name' => $rate->serviceName,
                'amount' => $rate->amount,
                'currency' => $rate->currency,
                'carrier_code' => $rate->carrierCode,
                'estimated_days' => $rate->estimatedDays,
                'estimated_delivery' => $rate->estimatedDelivery,
                'description' => $option?->description,
                'carrier_name' => $carrier?->name ?? $rate->carrierCode,
                'carrier_logo' => $carrier ? $service->getLogoUrl($carrier) : null,
            ];
        })->values()->all();
    }

    private function buildOriginAddress(): Address
    {
        $countryId = shopper_setting('country_id');
        $country = $countryId ? Country::query()->find($countryId) : null;

        return new Address(
            firstName: shopper_setting('name') ?? '',
            lastName: '',
            street: shopper_setting('street_address') ?? '',
            city: shopper_setting('city') ?? '',
            postalCode: shopper_setting('postal_code') ?? '',
            state: '',
            country: $country?->cca2 ?? '',
            phone: shopper_setting('phone_number'),
        );
    }

    private function buildDestinationAddress(array $shippingAddress): Address
    {
        $country = Country::query()->find($shippingAddress['country_id'] ?? null);

        return new Address(
            firstName: $shippingAddress['first_name'] ?? '',
            lastName: $shippingAddress['last_name'] ?? '',
            street: $shippingAddress['street_address'] ?? '',
            city: $shippingAddress['city'] ?? '',
            postalCode: $shippingAddress['postal_code'] ?? '',
            state: $shippingAddress['state'] ?? '',
            country: $country?->cca2 ?? '',
            company: $shippingAddress['company_name'] ?? null,
            street2: $shippingAddress['street_address_plus'] ?? null,
            phone: $shippingAddress['phone_number'] ?? null,
            email: auth()->user()?->email,
        );
    }

    /**
     * @return array<int, Package>
     */
    private function buildPackages(): array
    {
        $items = CartFacade::session(session()->getId())->getContent();
        $packages = [];

        foreach ($items as $item) {
            $model = $item->associatedModel;

            for ($i = 0; $i < $item->quantity; $i++) {
                $packages[] = new Package(
                    length: (float) ($model->depth_value ?? 10.0),
                    width: (float) ($model->width_value ?? 10.0),
                    height: (float) ($model->height_value ?? 10.0),
                    weight: (float) ($model->weight_value ?? 1.0),
                );
            }
        }

        return $packages ?: [new Package(length: 10.0, width: 10.0, height: 10.0, weight: 1.0)];
    }
}
