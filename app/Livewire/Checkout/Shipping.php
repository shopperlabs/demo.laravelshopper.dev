<?php

declare(strict_types=1);

namespace App\Livewire\Checkout;

use App\Actions\ZoneSessionManager;
use App\CheckoutSession;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Shopper\Cart\CartManager;
use Shopper\Core\Enum\AddressType;
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

        /** @var Address $shippingAddress */
        $shippingAddress = Address::query()->find($this->shippingAddressId);

        session()->put(CheckoutSession::SHIPPING_ADDRESS, $shippingAddress->toArray());
        session()->put(CheckoutSession::SAME_AS_SHIPPING, $this->sameAsShipping);

        $billingAddress = $this->sameAsShipping
            ? $shippingAddress
            : Address::query()->find($this->billingAddressId);

        session()->put(CheckoutSession::BILLING_ADDRESS, $billingAddress->toArray());

        $cart = cartSession();
        $cartManager = resolve(CartManager::class);

        $cartManager->addAddress($cart, AddressType::Shipping, [
            'first_name' => $shippingAddress->first_name,
            'last_name' => $shippingAddress->last_name,
            'company' => $shippingAddress->company_name,
            'address_1' => $shippingAddress->street_address,
            'address_2' => $shippingAddress->street_address_plus,
            'city' => $shippingAddress->city,
            'state' => $shippingAddress->state,
            'postal_code' => $shippingAddress->postal_code,
            'phone' => $shippingAddress->phone_number,
            'country_id' => $shippingAddress->country_id,
        ]);
        $cartManager->addAddress($cart, AddressType::Billing, [
            'first_name' => $billingAddress->first_name,
            'last_name' => $billingAddress->last_name,
            'company' => $billingAddress->company_name,
            'address_1' => $billingAddress->street_address,
            'address_2' => $billingAddress->street_address_plus,
            'city' => $billingAddress->city,
            'state' => $billingAddress->state,
            'postal_code' => $billingAddress->postal_code,
            'phone' => $billingAddress->phone_number,
            'country_id' => $billingAddress->country_id,
        ]);

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
