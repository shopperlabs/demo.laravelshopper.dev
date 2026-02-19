<?php

declare(strict_types=1);

use App\CheckoutSession;
use Darryldecode\Cart\Facades\CartFacade;
use function Livewire\Volt\{on, state};

state(['price' => CartFacade::session(session()->getId())->getTotal()]);

on(['cart-price-update' => function () {
    $shippingOption = session()->get(CheckoutSession::SHIPPING_OPTION);
    $this->price = $shippingOption
        ? (int) $shippingOption[0]['price'] + CartFacade::session(session()->getId())->getTotal()
        : 0;
}]);

?>

<dd class="text-base">
    {{ shopper_money_format(amount: $price, currency: current_currency()) }}
</dd>
