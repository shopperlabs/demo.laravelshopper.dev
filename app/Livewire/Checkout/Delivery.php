<?php

declare(strict_types=1);

namespace App\Livewire\Checkout;

use App\CheckoutSession;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Validate;
use Shopper\Core\Models\CarrierOption;
use Shopper\Core\Models\Zone;
use Spatie\LivewireWizard\Components\StepComponent;

final class Delivery extends StepComponent
{
    public const int CACHE_TTL = 7200;

    /**
     * @var array|Collection
     */
    public $options = [];

    #[Validate('required', message: 'You must select a delivery method')]
    public ?int $currentSelected = null;

    public function mount(): void
    {
        $countryId = data_get(session()->get(CheckoutSession::SHIPPING_ADDRESS), 'country_id');
        $shippingOption = session()->get(CheckoutSession::SHIPPING_OPTION);
        $this->currentSelected = $shippingOption ? $shippingOption[0]['id'] : null;

        $this->options = $countryId
            ? Cache::remember("shipping_options_country_{$countryId}", self::CACHE_TTL, function () use ($countryId): Collection {
                $zone = Zone::query()
                    ->whereHas('countries', fn ($q) => $q->where('id', $countryId))
                    ->where('is_enabled', true)
                    ->first();

                return $zone
                    ? $zone->shippingOptions()->where('is_enabled', true)->get()
                    : new Collection;
            })
            : [];
    }

    public function save(): void
    {
        $this->validate();

        session()->forget(CheckoutSession::SHIPPING_OPTION);

        session()->push(CheckoutSession::SHIPPING_OPTION, CarrierOption::query()->find($this->currentSelected)->toArray());

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
}
