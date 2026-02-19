<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<BlogCategory> */
final class BlogCategoryFactory extends Factory
{
    protected $model = BlogCategory::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        /** @var string $name */
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'is_enabled' => true,
        ];
    }
}
