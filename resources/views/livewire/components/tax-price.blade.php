<?php

declare(strict_types=1);

use function Livewire\Volt\{state};

state(['price' => 0])

?>

<dd>
    {{ shopper_money_format(amount: $price, currency: current_currency()) }}
</dd>
