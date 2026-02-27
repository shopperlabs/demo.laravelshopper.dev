<?php

declare(strict_types=1);

use Shopper\Cart\CartManager;
use Shopper\Cart\Discounts\DiscountValidator;
use Shopper\Cart\Exceptions\InvalidDiscountException;
use Shopper\Cart\Pipelines\CartPipelineContext;
use Shopper\Cart\Pipelines\CalculateLines;
use Shopper\Core\Models\Discount;
use function Livewire\Volt\{on, state};

state([
    'code' => '',
    'appliedCode' => fn () => cartSession()->coupon_code,
]);

on(['cart-price-update' => function () {
    $this->appliedCode = cartSession()->coupon_code;
}]);

$applyCoupon = function (): void {
    $this->resetErrorBag('code');
    $code = trim($this->code);

    if ($code === '') {
        return;
    }

    $cart = cartSession();
    $cartManager = resolve(CartManager::class);

    try {
        $cartManager->applyCoupon($cart, $code);
    } catch (InvalidDiscountException) {
        $this->addError('code', __('This discount code is invalid.'));

        return;
    }

    $discount = Discount::query()->where('code', $code)->first();
    $context = new CartPipelineContext($cart->refresh()->loadMissing(['lines.purchasable', 'lines.adjustments']));
    (new CalculateLines)->handle($context, fn ($ctx) => $ctx);

    $result = resolve(DiscountValidator::class)->validate($discount, $context);

    if (! $result->valid) {
        $cartManager->removeCoupon($cart);
        $this->addError('code', $result->failureReason);

        return;
    }

    $this->appliedCode = $code;
    $this->code = '';
    $this->dispatch('cart-price-update');
};

$removeCoupon = function (): void {
    $cart = cartSession();
    resolve(CartManager::class)->removeCoupon($cart);

    $this->appliedCode = null;
    $this->code = '';
    $this->resetErrorBag('code');
    $this->dispatch('cart-price-update');
};

?>

<div>
    @if ($appliedCode)
        <div class="flex items-center justify-between rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2">
            <div class="flex items-center gap-2">
                <flux:icon.tag variant="micro" class="text-emerald-600" />
                <span class="text-sm font-medium text-emerald-700">{{ $appliedCode }}</span>
            </div>
            <flux:button size="sm" variant="ghost" icon="x-mark" wire:click="removeCoupon">
                <span class="sr-only">{{ __('Remove coupon') }}</span>
            </flux:button>
        </div>
    @else
        <form wire:submit="applyCoupon">
            <flux:field>
                <div class="flex items-center gap-2">
                    <flux:input wire:model="code" icon="tag" placeholder="{{ __('Discount code') }}" />
                    <flux:button type="submit" wire:target="applyCoupon">
                        {{ __('Apply') }}
                    </flux:button>
                </div>
                <flux:error name="code" />
            </flux:field>
        </form>
    @endif
</div>
