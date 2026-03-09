<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\GetCountriesByZone;
use App\Actions\ZoneSessionManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

final class ZoneDetector
{
    public function handle(Request $request, Closure $next): Response
    {
        $countries = resolve(GetCountriesByZone::class)->handle();

        $this->setDefaultZone($countries);

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
