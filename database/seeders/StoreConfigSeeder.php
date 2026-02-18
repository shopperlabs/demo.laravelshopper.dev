<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Shopper\Core\Models\Inventory;
use Shopper\Core\Models\Setting;

class StoreConfigSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn(PHP_EOL.'Creating admin user...');

        /** @var User $admin */
        $admin = User::factory()->create([
            'first_name' => 'Shopper',
            'last_name' => 'Admin',
            'email' => 'admin@laravelshopper.dev',
            'password' => Hash::make('demo.Shopper@2026!'),
        ]);

        /** @var string $role */
        $role = config('shopper.core.roles.admin');
        $admin->assignRole($role);

        $this->command->info('Admin user created.');

        $this->command->warn(PHP_EOL.'Configuring store settings...');

        $settings = [
            'name' => 'ShopStation',
            'email' => 'contact@shopstation.com',
            'about' => null,
            'phone_number' => null,
            'street_address' => fake()->streetAddress(),
            'postal_code' => fake()->postcode(),
            'state' => 'Littoral',
            'city' => fake()->city(),
            'country_id' => 47,
            'default_currency_id' => 151,
            'currencies' => [151, 44, 144],
            'facebook_link' => null,
            'instagram_link' => '',
            'twitter_link' => 'https://twitter.com/laravelshopper',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], [
                'value' => $value,
                'locked' => true,
                'display_name' => Setting::lockedAttributesDisplayName($key),
            ]);
        }

        Inventory::query()->create([
            'name' => 'ShopStation',
            'code' => 'shopstation',
            'email' => 'contact@shopstation.com',
            'street_address' => fake()->streetAddress(),
            'postal_code' => fake()->postcode(),
            'city' => fake()->city(),
            'state' => 'Littoral',
            'is_default' => true,
            'country_id' => 47,
        ]);

        $this->command->info('Store settings configured.');
    }
}
