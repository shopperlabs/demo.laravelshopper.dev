<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Concerns\WithProgressBar;
use Illuminate\Database\Seeder;
use Shopper\Core\Models\Address;

class CustomerSeeder extends Seeder
{
    use WithProgressBar;

    public function run(): void
    {
        $this->command->warn(PHP_EOL . 'Creating customers...');

        $this->withProgressBar(100, function () {
            $customer = User::factory()
                ->has(Address::factory()->count(rand(1, 3)))
                ->create();

            $customer->assignRole(config('shopper.core.roles.user'));

            return collect([$customer]);
        });

        $this->command->info('Customers created successfully.');
    }
}
