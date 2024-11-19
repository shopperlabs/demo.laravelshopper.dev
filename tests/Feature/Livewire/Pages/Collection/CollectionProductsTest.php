<?php

declare(strict_types=1);

use App\Livewire\Pages\Collection\CollectionProducts;
use App\Models\Collection;
use App\Models\Product;
use Livewire\Livewire;

describe(CollectionProducts::class, function (): void {
    it('can render collection page', function (): void {
        $collection = Collection::factory()
            ->hasProducts(3)
            ->create([
                'slug' => 'nike',
            ]);

        Livewire::test(CollectionProducts::class, ['slug' => $collection->slug])
            ->assertSuccessful()
            ->assertSee($collection->name);
    });

    it('can displays products of a collections', function (): void {
        $collection = Collection::factory()->create([
            'slug' => 'nike',
        ]);

        $products = Product::factory()->count(3)->create();

        foreach ($products as $product) {
            $product->collections()->attach($collection->id);
        }

        Livewire::test(CollectionProducts::class, ['slug' => $collection->slug])
            ->assertSuccessful()
            ->assertSee($products[0]->name)
            ->assertSee($products[1]->name)
            ->assertSee($products[2]->name);
    });
});
