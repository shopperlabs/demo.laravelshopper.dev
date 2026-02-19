<?php

declare(strict_types=1);

use App\CheckoutSession;
use function Livewire\Volt\{on, state};

state(['price' => 0]);

on(['cart-price-update' => function () {
    $shippingOption = session()->get(CheckoutSession::SHIPPING_OPTION);
    $this->price = $shippingOption ? $shippingOption[0]['price'] : 0;
}]);

?>

<dd>
    {{ shopper_money_format(amount: $price, currency: current_currency()) }}
</dd>
