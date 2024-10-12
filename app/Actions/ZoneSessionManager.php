<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\CountryByZoneData;

final class ZoneSessionManager
{
    public static function checkSession(): bool
    {
        return session()->exists('zone');
    }

    public static function setSession(CountryByZoneData $zone): void
    {
        if (self::checkSession()) {
            session()->forget('zone');
        }

        session()->put('zone', $zone);
    }

    public static function getSession(): ?CountryByZoneData
    {
        return session()->get('zone');
    }
}
