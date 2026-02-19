<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends AbstractSeeder
{
    public function run(): void
    {
        $data = $this->getSeedData('blog_posts');
        $author = User::query()->first();

        $this->command->warn(PHP_EOL.'Creating blog posts...');

        DB::transaction(function () use ($data, $author): void {
            foreach ($data as $categoryData) {
                $category = BlogCategory::query()->create([
                    'name' => $categoryData->category,
                    'slug' => $categoryData->category_slug,
                    'description' => $categoryData->category_description,
                    'is_enabled' => true,
                ]);

                foreach ($categoryData->posts as $postData) {
                    $post = BlogPost::query()->create([
                        'blog_category_id' => $category->id,
                        'user_id' => $author->id,
                        'title' => $postData->title,
                        'slug' => $postData->slug,
                        'excerpt' => $postData->excerpt,
                        'content' => $postData->content,
                        'is_published' => $postData->is_published,
                        'published_at' => Carbon::parse($postData->published_at),
                    ]);

                    if ($postData->image) {
                        $post->addMedia($this->imagePath('blog', $postData->image))
                            ->preservingOriginal()
                            ->toMediaCollection('image');
                    }
                }
            }
        });

        $this->command->info('Blog posts created successfully.');
    }
}
