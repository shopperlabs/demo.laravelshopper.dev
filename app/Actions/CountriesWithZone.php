<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Collection;

final class CountriesWithZone
{
    public function handle(): Collection
    {
        return once(function () {
            return resolve(GetCountriesByZone::class)->handle();
        });
    }
}
