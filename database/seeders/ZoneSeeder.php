<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\Carrier;
use Shopper\Core\Models\CarrierOption;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\PaymentMethod;
use Shopper\Core\Models\Zone;

class ZoneSeeder extends AbstractSeeder
{
    public function run(): void
    {
        $zones = $this->getSeedData('zones');

        $this->command->warn(PHP_EOL.'Creating zones...');

        DB::transaction(function () use ($zones): void {
            foreach ($zones as $zone) {
                $currency = Currency::query()->where('code', $zone->currency_code)->first();

                $zoneModel = Zone::query()->create([
                    'name' => $zone->name,
                    'slug' => $zone->slug,
                    'code' => $zone->code,
                    'is_enabled' => $zone->is_enabled,
                    'currency_id' => $currency->id,
                ]);

                $countryIds = Country::query()
                    ->whereIn('cca3', $zone->countries)
                    ->pluck('id');
                $zoneModel->countries()->attach($countryIds);

                $carrierIds = Carrier::query()
                    ->whereIn('slug', $zone->carriers)
                    ->pluck('id');
                $zoneModel->carriers()->attach($carrierIds);

                $paymentIds = PaymentMethod::query()
                    ->whereIn('slug', $zone->payment_methods)
                    ->pluck('id');
                $zoneModel->paymentMethods()->attach($paymentIds);

                $collectionIds = Collection::query()
                    ->whereIn('slug', $zone->collections)
                    ->pluck('id');
                $zoneModel->collections()->attach($collectionIds);

                if (isset($zone->shipping_options) && filled($zone->shipping_options)) {
                    foreach ($zone->shipping_options as $option) {
                        $carrier = Carrier::query()->where('slug', $option->carrier)->first();

                        CarrierOption::query()->create([
                            'carrier_id' => $carrier->id,
                            'zone_id' => $zoneModel->id,
                            'name' => $option->name,
                            'description' => $option->description,
                            'price' => $option->price,
                            'is_enabled' => $option->is_enabled,
                        ]);
                    }
                }
            }
        });

        $this->command->info('Zones created successfully.');
    }
}
