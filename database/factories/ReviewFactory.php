<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Shopper\Core\Models\Review;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'content' => $this->faker->realText(),
            'approved' => $this->faker->boolean(),
            'reviewable_type' => 'product',
            'reviewable_id' => Product::InRandomOrder()->id,
            'author_type' => 'App\Models\User',
            'author_id' => User::InRandomOrder()->id,
        ];
    }
}
