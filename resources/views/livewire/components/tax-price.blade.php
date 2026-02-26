<?php

declare(strict_types=1);

use Shopper\Cart\CartManager;
use function Livewire\Volt\{on, state};

state(['price' => function () {
    return app(CartManager::class)->calculate(cartSession())->taxTotal;
}]);

on(['cart-price-update' => function () {
    $this->price = app(CartManager::class)->calculate(cartSession())->taxTotal;
}]);

?>

<dd>
    {{ format_cents($price) }}
</dd>
