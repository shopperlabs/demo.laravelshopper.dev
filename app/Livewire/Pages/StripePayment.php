<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Shopper\Core\Models\Order;

#[Layout('components.layouts.templates.light')]
final class StripePayment extends Component
{
    public Order $order;

    public string $clientSecret;

    public string $publishableKey;

    public string $returnUrl;

    public function mount(string $number): void
    {
        $this->order = Order::query()
            ->where('number', $number)
            ->where('customer_id', auth()->id())
            ->firstOrFail();

        $stripePayment = session()->pull('stripe_payment');

        if (! $stripePayment) {
            $this->redirect(route('order-confirmed', ['number' => $number]));

            return;
        }

        $this->clientSecret = $stripePayment['client_secret'];
        $this->publishableKey = $stripePayment['publishable_key'];
        $this->returnUrl = route('order-confirmed', ['number' => $this->order->number]);
    }

    public function render(): View
    {
        return view('livewire.pages.stripe-payment')
            ->title(__('Complete your payment'));
    }
}
