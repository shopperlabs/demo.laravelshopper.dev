<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\CountryByZoneData;
use Illuminate\Support\Collection;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\Zone;

final class GetCountriesByZone
{
    public function handle(): Collection
    {
        $zones = Zone::with(['currency', 'countries'])
            ->scopes('enabled')
            ->get();

        $countriesByZone = $zones->map(fn (Zone $zone) => $zone->countries->map(fn (Country $country): CountryByZoneData => CountryByZoneData::fromArray([
            'zone_id' => $zone->id,
            'zone_name' => $zone->name,
            'zone_code' => $zone->code,
            'country_id' => $country->id,
            'country_name' => $country->name,
            'country_code' => $country->cca2,
            'country_flag' => $country->svg_flag,
            'currency_code' => $zone->currency->code,
        ])));

        return $countriesByZone->flatten(1);
    }
}
