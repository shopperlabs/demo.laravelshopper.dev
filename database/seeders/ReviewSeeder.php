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
        for ($i = 1; $i <= 100; $i++) {
            Review::query()->create([
                'rating' => fake()->numberBetween(1, 5),
                'content' => fake()->realText(),
                'reviewrateable_id' => Product::all()->random()->id,
                'reviewrateable_type' => 'product',
                'approved' => true,
                'author_id' => User::all()->random()->id,
                'author_type' => User::class,
            ]);
        }
    }
}
