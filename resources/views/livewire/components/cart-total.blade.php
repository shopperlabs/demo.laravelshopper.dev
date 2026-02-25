<?php

declare(strict_types=1);

use App\Actions\CalculateCartTax;
use App\CheckoutSession;
use Darryldecode\Cart\Facades\CartFacade;
use function Livewire\Volt\{on, state};

state(['price' => CartFacade::session(session()->getId())->getTotal()]);

on(['cart-price-update' => function () {
    $shippingOption = session()->get(CheckoutSession::SHIPPING_OPTION);
    $shippingPrice = $shippingOption ? (int) $shippingOption[0]['price'] : 0;
    $subtotal = CartFacade::session(session()->getId())->getTotal();

    $taxResult = (new CalculateCartTax)->handle();
    $taxTotal = $taxResult['is_inclusive'] ? 0 : $taxResult['total'];

    $this->price = $subtotal + $shippingPrice + $taxTotal;
}]);

?>

<dd class="text-base">
    {{ shopper_money_format(amount: $price, currency: current_currency()) }}
</dd>
