<?php

declare(strict_types=1);

use function Livewire\Volt\{state};

state(['price' => 0])

?>

<dd>
    {{ shopper_money_format(amount: $price, currency: \App\Actions\ZoneSessionManager::getSession()?->currencyCode) }}
</dd>
