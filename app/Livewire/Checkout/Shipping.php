<?php

declare(strict_types=1);

namespace App\Livewire\Checkout;

use App\Actions\ZoneSessionManager;
use App\CheckoutSession;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Shopper\Core\Models\Address;
use Spatie\LivewireWizard\Components\StepComponent;

final class Shipping extends StepComponent
{
    #[Validate('required', message: 'You need to select a delivery address')]
    public ?int $shippingAddressId = null;

    #[Validate('boolean')]
    public bool $sameAsShipping = false;

    #[Validate('required_if_declined:sameAsShipping', message: 'You must choose a billing address')]
    public ?int $billingAddressId = null;

    public function mount(): void
    {
        $this->shippingAddressId = data_get(session()->get(CheckoutSession::SHIPPING_ADDRESS), 'id');
        $this->billingAddressId = data_get(session()->get(CheckoutSession::BILLING_ADDRESS), 'id');
        $this->sameAsShipping = (bool) session()->get(CheckoutSession::SAME_AS_SHIPPING);
    }

    public function updatedSameAsShipping(): void
    {
        if (! $this->sameAsShipping) {
            $this->billingAddressId = null;
        }
    }

    public function save(): void
    {
        $this->validate();

        session()->forget(CheckoutSession::KEY);

        $shippingAddress = Address::query()->find($this->shippingAddressId)->toArray();

        session()->put(CheckoutSession::SHIPPING_ADDRESS, $shippingAddress);
        session()->put(CheckoutSession::SAME_AS_SHIPPING, $this->sameAsShipping);
        session()->put(CheckoutSession::BILLING_ADDRESS, $this->sameAsShipping
            ? $shippingAddress
            : Address::query()->find($this->billingAddressId)->toArray());

        $this->nextStep();
    }

    public function stepInfo(): array
    {
        return [
            'label' => __('Address'),
            'complete' => session()->exists(CheckoutSession::KEY)
                && session()->get(CheckoutSession::SHIPPING_ADDRESS) !== null,
        ];
    }

    #[On('addresses-updated')]
    public function render(): View
    {
        $countryId = ZoneSessionManager::getSession()?->countryId;
        $addresses = Auth::user()->addresses()
            ->with('country')
            ->where('country_id', $countryId)
            ->get()
            ->groupBy('type');

        return view('livewire.checkout.shipping', [
            'addresses' => $addresses,
        ]);
    }
}
