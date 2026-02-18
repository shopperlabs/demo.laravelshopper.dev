<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Shopper\Core\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::query()->pluck('id');
        $customers = User::query()->scopes('customers')->pluck('id');

        if ($products->isEmpty() || $customers->isEmpty()) {
            $this->command->warn('No products or customers found. Skipping reviews.');

            return;
        }

        $this->command->warn(PHP_EOL.'Creating reviews...');

        for ($i = 1; $i <= 100; $i++) {
            Review::query()->create([
                'rating' => fake()->numberBetween(1, 5),
                'content' => fake()->realText(),
                'reviewrateable_id' => $products->random(),
                'reviewrateable_type' => 'product',
                'approved' => fake()->boolean(80),
                'author_id' => $customers->random(),
                'author_type' => User::class,
            ]);
        }

        $this->command->info('Reviews created successfully.');
    }
}
