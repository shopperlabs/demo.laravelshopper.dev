<?php

declare(strict_types=1);

use App\Actions\ZoneSessionManager;

if (! function_exists('current_currency')) {
    function current_currency(): string
    {
        return ZoneSessionManager::checkSession()
            ? ZoneSessionManager::getSession()->currencyCode
            : shopper_currency();
    }
}
