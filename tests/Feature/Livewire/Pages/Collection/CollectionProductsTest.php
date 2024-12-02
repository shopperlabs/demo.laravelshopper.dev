<?php

declare(strict_types=1);

use App\Livewire\Pages\Collection\CollectionProducts;
use App\Models\Collection;
use App\Models\Product;
use Livewire\Livewire;

use function Pest\Laravel\get;

describe(CollectionProducts::class, function (): void {
    it('can render collection page', function (): void {
        $collection = Collection::factory()
            ->hasProducts(3)
            ->create([
                'slug' => 'new-deals',
            ]);

        get(route('collection.products', $collection))->assertOk();

        Livewire::test(CollectionProducts::class, ['collection' => $collection])
            ->assertSuccessful()
            ->assertSee($collection->name);
    });

    it('can displays products of a collections', function (): void {
        $collection = Collection::factory()->create([
            'slug' => 'best-deals',
        ]);

        $products = Product::factory([
            'published_at' => now()->subDay(),
            'is_visible' => true,
        ])->count(3)->create();

        foreach ($products as $product) {
            $product->collections()->attach($collection->id);
        }

        Livewire::test(CollectionProducts::class, ['collection' => $collection])
            ->assertSuccessful()
            ->assertSee($products[0]->name)
            ->assertSee($products[1]->name)
            ->assertSee($products[2]->name);
    });
});
