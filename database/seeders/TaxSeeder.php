<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\TaxRate;
use Shopper\Core\Models\TaxZone;

class TaxSeeder extends AbstractSeeder
{
    public function run(): void
    {
        $taxes = $this->getSeedData('taxes');

        $this->command->warn(PHP_EOL.'Creating tax zones and rates...');

        DB::transaction(function () use ($taxes): void {
            foreach ($taxes as $tax) {
                $country = Country::query()->where('cca2', $tax->country_code)->first();

                if (! $country) {
                    continue;
                }

                $zone = TaxZone::query()->create([
                    'country_id' => $country->id,
                    'is_tax_inclusive' => $tax->is_tax_inclusive,
                ]);

                foreach ($tax->rates as $rate) {
                    TaxRate::query()->create([
                        'tax_zone_id' => $zone->id,
                        'name' => $rate->name,
                        'code' => $rate->code,
                        'rate' => $rate->rate,
                        'is_default' => $rate->is_default,
                    ]);
                }

                if (isset($tax->provinces)) {
                    foreach ($tax->provinces as $province) {
                        $provinceZone = TaxZone::query()->create([
                            'country_id' => $country->id,
                            'parent_id' => $zone->id,
                            'province_code' => $province->province_code,
                            'is_tax_inclusive' => $province->is_tax_inclusive,
                        ]);

                        foreach ($province->rates as $rate) {
                            TaxRate::query()->create([
                                'tax_zone_id' => $provinceZone->id,
                                'name' => $rate->name,
                                'code' => $rate->code,
                                'rate' => $rate->rate,
                                'is_default' => $rate->is_default,
                            ]);
                        }
                    }
                }
            }
        });

        $this->command->info('Tax zones and rates created successfully.');
    }
}
