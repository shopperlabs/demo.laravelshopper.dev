<?php

declare(strict_types=1);

namespace App\Livewire\Checkout;

use App\Actions\CreateOrder;
use App\CheckoutSession;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Validate;
use Shopper\Core\Models\PaymentMethod;
use Shopper\Core\Models\Zone;
use Shopper\Payment\Services\PaymentProcessingService;
use Spatie\LivewireWizard\Components\StepComponent;

final class Payment extends StepComponent
{
    public const int CACHE_TTL = 3600;

    #[Validate('required', message: 'You must select a payment method')]
    public ?int $currentSelected = null;

    /** @var array<int, array<string, mixed>> */
    public array $methods = [];

    public function mount(): void
    {
        $countryId = data_get(session()->get(CheckoutSession::SHIPPING_ADDRESS), 'country_id');
        $payment = session()->get(CheckoutSession::PAYMENT);
        $this->currentSelected = $payment ? $payment[0]['id'] : null;

        if (! $countryId) {
            return;
        }

        $zone = Cache::remember(
            "payment_zone_country_{$countryId}",
            self::CACHE_TTL,
            fn () => Zone::query()
                ->whereHas('countries', fn ($q) => $q->where('id', $countryId))
                ->where('is_enabled', true)
                ->first(),
        );

        if (! $zone) {
            return;
        }

        $this->methods = Cache::remember(
            "payment_methods_zone_{$zone->id}",
            self::CACHE_TTL,
            fn (): array => $this->fetchMethods($zone),
        );
    }

    public function save(): void
    {
        $this->validate();

        $selectedMethod = collect($this->methods)
            ->first(fn (array $method): bool => $method['id'] === $this->currentSelected);

        if (! $selectedMethod) {
            return;
        }

        session()->forget(CheckoutSession::PAYMENT);
        session()->push(CheckoutSession::PAYMENT, $selectedMethod);

        $order = (new CreateOrder)->handle();

        $service = resolve(PaymentProcessingService::class);
        $result = $service->initiate($order);

        session()->forget(CheckoutSession::KEY);

        if (! $result->success) {
            session()->flash('error', $result->message ?? __('Payment initiation failed.'));
            $this->redirect(route('order-confirmed', ['number' => $order->number]));

            return;
        }

        if ($result->clientSecret) {
            session()->put('stripe_payment', [
                'client_secret' => $result->clientSecret,
                'publishable_key' => $result->data['publishable_key'] ?? config('stripe.publishable_key'),
            ]);

            $this->redirect(route('stripe-payment', ['number' => $order->number]));

            return;
        }

        if ($result->redirectUrl) {
            $this->redirect($result->redirectUrl);

            return;
        }

        $this->redirect(route('order-confirmed', ['number' => $order->number]));
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

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetchMethods(Zone $zone): array
    {
        $service = resolve(PaymentProcessingService::class);

        return $service->getMethodsForZone($zone)
            ->map(fn (PaymentMethod $method) => [
                'id' => $method->id,
                'title' => $method->title,
                'slug' => $method->slug,
                'description' => $method->description,
                'logo' => $service->getLogoUrl($method),
            ])
            ->values()
            ->all();
    }
}
