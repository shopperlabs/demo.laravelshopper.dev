<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends AbstractSeeder
{
    public function run(): void
    {
        $categories = $this->getSeedData('categories');

        $thumbnailCollection = config('shopper.media.storage.thumbnail_collection', 'thumbnail');

        $this->command->warn(PHP_EOL . 'Creating categories...');

        DB::transaction(function () use ($categories, $thumbnailCollection): void {
            foreach ($categories as $category) {
                $parent = Category::query()->create([
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'is_enabled' => $category->is_enabled,
                    'position' => $category->position,
                ]);

                if ($category->image) {
                    $parent->addMedia($this->imagePath('categories', $category->image))
                        ->preservingOriginal()
                        ->toMediaCollection($thumbnailCollection);
                }

                foreach ($category->children ?? [] as $child) {
                    $childModel = Category::query()->create([
                        'name' => $child->name,
                        'slug' => $child->slug,
                        'description' => $child->description,
                        'is_enabled' => $child->is_enabled,
                        'position' => $child->position,
                        'parent_id' => $parent->id,
                    ]);

                    if ($child->image) {
                        $childModel->addMedia($this->imagePath('categories', $child->image))
                            ->preservingOriginal()
                            ->toMediaCollection($thumbnailCollection);
                    }
                }
            }
        });

        $this->command->info('Categories created successfully.');
    }
}
