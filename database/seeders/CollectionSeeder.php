<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\CollectionRule;

class CollectionSeeder extends AbstractSeeder
{
    public function run(): void
    {
        $collections = $this->getSeedData('collections');

        $thumbnailCollection = config('shopper.media.storage.thumbnail_collection', 'thumbnail');

        $this->command->warn(PHP_EOL.'Creating collections...');

        DB::transaction(function () use ($collections, $thumbnailCollection): void {
            foreach ($collections as $collection) {
                $collectionModel = Collection::query()->create([
                    'name' => $collection->name,
                    'slug' => $collection->slug,
                    'description' => $collection->description,
                    'type' => $collection->type,
                    'match_conditions' => $collection->match_conditions,
                    'published_at' => now(),
                ]);

                if ($collection->image) {
                    $collectionModel->addMedia($this->imagePath('collections', $collection->image))
                        ->preservingOriginal()
                        ->toMediaCollection($thumbnailCollection);
                }

                foreach ($collection->rules ?? [] as $rule) {
                    CollectionRule::query()->create([
                        'collection_id' => $collectionModel->id,
                        'rule' => $rule->rule,
                        'operator' => $rule->operator,
                        'value' => $rule->value,
                    ]);
                }
            }
        });

        $this->command->info('Collections created successfully.');
    }
}
