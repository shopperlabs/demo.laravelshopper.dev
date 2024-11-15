<?php

declare(strict_types=1);

namespace App\Livewire\Checkout;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Shopper\Core\Models\CarrierOption;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\Zone;
use Spatie\LivewireWizard\Components\StepComponent;

final class Delivery extends StepComponent
{
    /**
     * @var array|Collection
     */
    public $options = [];

    #[Validate('required', message: 'You must select a delivery method')]
    public ?int $currentSelected = null;

    public function mount(): void
    {
        $countryId = data_get(session()->get('checkout'), 'shipping_address.country_id');
        $this->currentSelected = data_get(session()->get('checkout'), 'shipping_option')
            ? data_get(session()->get('checkout'), 'shipping_option')[0]['id']
            : null;

        $country = Country::query()->with('zones')->find($countryId);
        /** @var ?Zone $zone */
        // @phpstan-ignore-next-line
        $zone = $country->zones()
            ->with('shippingOptions')
            ->where('is_enabled', true)
            ->first();

        $this->options = $zone
            ? $zone->shippingOptions()->where('is_enabled', true)->get()
            : [];
    }

    public function save(): void
    {
        $this->validate();

        session()->forget('checkout.shipping_option');

        session()->push('checkout.shipping_option', CarrierOption::query()->find($this->currentSelected)->toArray());

        $this->dispatch('cart-price-update');

        $this->nextStep();
    }

    public function stepInfo(): array
    {
        return [
            'label' => __('Delivery method'),
            'complete' => session()->exists('checkout')
                && data_get(session()->get('checkout'), 'shipping_option') !== null,
        ];
    }

    public function render(): View
    {
        return view('livewire.checkout.delivery');
    }
}
