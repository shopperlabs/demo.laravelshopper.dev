<?php

declare(strict_types=1);

namespace App\Livewire\Checkout;

use App\Actions\CreateOrder;
use App\Actions\Payment\PayWithCash;
use App\Actions\Payment\PayWithNotchPay;
use App\Actions\Payment\PayWithStripe;
use App\CheckoutSession;
use App\Enums\PaymentType;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Shopper\Core\Models\PaymentMethod;
use Shopper\Core\Models\Zone;
use Spatie\LivewireWizard\Components\StepComponent;

final class Payment extends StepComponent
{
    #[Validate('required', message: 'You must select a payment method')]
    public ?int $currentSelected = null;

    /**
     * @var array|Collection
     */
    public $methods = [];

    public function mount(): void
    {
        $countryId = data_get(session()->get(CheckoutSession::SHIPPING_ADDRESS), 'country_id');
        $payment = session()->get(CheckoutSession::PAYMENT);
        $this->currentSelected = $payment ? $payment[0]['id'] : null;

        $zone = Zone::query()
            ->whereHas('countries', fn ($q) => $q->where('id', $countryId))
            ->where('is_enabled', true)
            ->with('paymentMethods')
            ->first();

        $this->methods = $zone?->paymentMethods ?? collect();
    }

    public function save(): void
    {
        $this->validate();

        session()->forget(CheckoutSession::PAYMENT);

        session()->push(CheckoutSession::PAYMENT, PaymentMethod::query()->find($this->currentSelected)->toArray());

        $order = (new CreateOrder)->handle();

        match (session()->get(CheckoutSession::PAYMENT)[0]['slug']) {
            PaymentType::Cash() => (new PayWithCash)->handle($order),
            PaymentType::NotchPay() => (new PayWithNotchPay)->handle($order),
            PaymentType::Stripe() => (new PayWithStripe)->handle($order),
        };
    }

    public function stepInfo(): array
    {
        return [
            'label' => __('Payment'),
            'complete' => session()->exists(CheckoutSession::KEY)
                && session()->get(CheckoutSession::PAYMENT) !== null,
        ];
    }

    public function render(): View
    {
        return view('livewire.checkout.payment');
    }
}
