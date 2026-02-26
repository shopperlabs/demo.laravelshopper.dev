<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Shopper\Core\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn(PHP_EOL.'Creating payment methods...');

        PaymentMethod::query()->firstOrCreate(
            ['slug' => 'stripe'],
            ['title' => 'Stripe', 'is_enabled' => true, 'driver' => 'stripe'],
        );

        $this->command->info('Payment methods created successfully.');
    }
}
