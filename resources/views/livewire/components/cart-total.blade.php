<?php

declare(strict_types=1);

use Darryldecode\Cart\Facades\CartFacade;
use function Livewire\Volt\{on, state};

state(['price' => CartFacade::session(session()->getId())->getTotal()]);

on(['cart-price-update' => function () {
    $this->price = data_get(session()->get('checkout'), 'shipping_option')
        ? (int) data_get(session()->get('checkout'), 'shipping_option')[0]['price'] + CartFacade::session(session()->getId())->getTotal()
        : 0;
}]);

?>

<dd class="text-base">
    {{ shopper_money_format(amount: $price, currency: \App\Actions\ZoneSessionManager::getSession()?->currencyCode) }}
</dd>
