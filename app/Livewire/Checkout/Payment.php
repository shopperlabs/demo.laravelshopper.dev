<?php

declare(strict_types=1);

namespace App\Livewire\Checkout;

use App\Actions\CreateOrder;
use App\Actions\Payment\PayWithCash;
use App\Actions\Payment\PayWithNotchPay;
use App\Actions\Payment\PayWithStripe;
use App\Enums\PaymentType;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\PaymentMethod;
use Shopper\Core\Models\Zone;
use Spatie\LivewireWizard\Components\StepComponent;

final class Payment extends StepComponent
{
    #[Validate('required', message: 'Vous devez sélectionner un moyen de paiement')]
    public ?int $currentSelected = null;

    public array|Collection $methods = [];

    public function mount(): void
    {
        $countryId = data_get(session()->get('checkout'), 'shipping_address.country_id');
        $this->currentSelected = data_get(session()->get('checkout'), 'payment')
            ? data_get(session()->get('checkout'), 'payment')[0]['id']
            : null;

        $country = Country::query()->with('zones')->find($countryId);
        /** @var ?Zone $zone */
        $zone = $country->zones()
            ->with('paymentMethods')
            ->where('is_enabled', true)
            ->first();

        $this->methods = $zone ? $zone->paymentMethods : [];
    }

    public function save(): void
    {
        $this->validate();

        session()->forget('checkout.payment');

        session()->push('checkout.payment', PaymentMethod::query()->find($this->currentSelected)->toArray());

        $order = (new CreateOrder)->handle();

        match (data_get(session()->get('checkout'), 'payment')[0]['slug']) {
            PaymentType::Cash() => (new PayWithCash)->handle($order),
            PaymentType::NotchPay() => (new PayWithNotchPay)->handle($order),
            PaymentType::Stripe() => (new PayWithStripe)->handle($order),
        };
    }

    public function stepInfo(): array
    {
        return [
            'label' => __('Paiement'),
            'complete' => session()->exists('checkout')
                && data_get(session()->get('checkout'), 'payment') !== null,
        ];
    }

    public function render(): View
    {
        return view('livewire.checkout.payment');
    }
}
