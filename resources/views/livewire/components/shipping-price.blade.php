<?php

declare(strict_types=1);

use function Livewire\Volt\{on, state};

state(['price' => 0]);

on(['cart-price-update' => function () {
    $this->price = data_get(session()->get('checkout'), 'shipping_option')
        ? data_get(session()->get('checkout'), 'shipping_option')[0]['price']
        : 0;
}]);

?>

<dd>
    {{ shopper_money_format(amount: $price, currency: current_currency()) }}
</dd>
