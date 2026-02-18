<?php

declare(strict_types=1);

namespace App\Actions;

use Exception;
use Illuminate\Support\Collection;

final class CountriesWithZone
{
    /**
     * @throws Exception
     */
    public function handle(): Collection
    {
        return resolve(GetCountriesByZone::class)->handle();
    }
}
