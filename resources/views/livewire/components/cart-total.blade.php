<?php

declare(strict_types=1);

use App\CheckoutSession;
use Shopper\Cart\CartManager;
use function Livewire\Volt\{on, state};

state(['price' => function () {
    $cart = cartSession();

    return app(CartManager::class)->calculate($cart)->total;
}]);

on(['cart-price-update' => function () {
    $cart = cartSession();
    $context = app(CartManager::class)->calculate($cart);

    $shippingOption = session()->get(CheckoutSession::SHIPPING_OPTION);
    $shippingPrice = $shippingOption ? (int) $shippingOption[0]['price'] : 0;
    $divisor = is_no_division_currency($cart->currency_code) ? 1 : 100;

    $this->price = $context->total + (int) ($shippingPrice * $divisor);
}]);

?>

<dd class="text-base">
    {{ format_cents($price) }}
</dd>
