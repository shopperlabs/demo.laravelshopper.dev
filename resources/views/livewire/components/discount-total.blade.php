<?php

declare(strict_types=1);

use Shopper\Cart\CartManager;
use function Livewire\Volt\{on, state};

state(['discount' => function () {
    return app(CartManager::class)->calculate(cartSession())->discountTotal;
}]);

on(['cart-price-update' => function () {
    $this->discount = app(CartManager::class)->calculate(cartSession())->discountTotal;
}]);

?>

<div>
    @if ($discount > 0)
        <div class="flex items-center justify-between">
            <dt class="text-zinc-500">{{ __('Discount') }}</dt>
            <dd class="text-emerald-600">-{{ format_cents($discount) }}</dd>
        </div>
    @endif
</div>
