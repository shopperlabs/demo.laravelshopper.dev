<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<BlogPost> */
final class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $title = fake()->unique()->sentence();

        return [
            'blog_category_id' => BlogCategory::factory(),
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->randomHtml(),
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-6 months'),
        ];
    }

    public function draft(): static
    {
        return $this->state([
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}
