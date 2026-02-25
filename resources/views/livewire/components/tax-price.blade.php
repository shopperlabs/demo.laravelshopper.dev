<?php

declare(strict_types=1);

use App\Actions\CalculateCartTax;
use function Livewire\Volt\{on, state};

state(['price' => (new CalculateCartTax)->handle()['total']]);

on(['cart-price-update' => function () {
    $this->price = (new CalculateCartTax)->handle()['total'];
}]);

?>

<dd>
    {{ shopper_money_format(amount: $price, currency: current_currency()) }}
</dd>
