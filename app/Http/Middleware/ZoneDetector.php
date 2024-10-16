<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\CountriesWithZone;
use App\Actions\ZoneSessionManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

final class ZoneDetector
{
    public function handle(Request $request, Closure $next): Response
    {
        // @Todo: Detect the user geolocation ip to retrieve country
        $geoLocation = session()->get('ip-geolocation');

        $countries = (new CountriesWithZone)->handle();

        if ($geoLocation) {
            $userZone = $countries->firstWhere('countryCode', $geoLocation->countryCode);

            if ($userZone && ! ZoneSessionManager::checkSession()) {
                ZoneSessionManager::setSession($userZone);
            } else {
                $this->setDefaultZone($countries);
            }
        } else {
            $this->setDefaultZone($countries);
        }

        return $next($request);
    }

    private function setDefaultZone(Collection $countries): void
    {
        $defaultZone = $countries->firstWhere('zoneCode', config('starter-kit.default_zone'));

        if (! ZoneSessionManager::checkSession() && $defaultZone) {
            ZoneSessionManager::setSession($defaultZone);
        }
    }
}
