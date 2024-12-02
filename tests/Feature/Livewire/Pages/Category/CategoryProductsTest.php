<?php

declare(strict_types=1);

use App\Livewire\Pages\Category\CategoryProducts;
use App\Models\Category;
use App\Models\Product;
use Livewire\Livewire;

use function Pest\Laravel\get;

describe(CategoryProducts::class, function (): void {
    it('can render category products page', function (): void {
        /** @var Category $category */
        $category = Category::factory()->create([
            'slug' => 'homme',
            'is_enabled' => true,
        ]);

        get(route('category.products', $category))->assertOk();

        Livewire::test(CategoryProducts::class, ['category' => $category])
            ->assertSuccessful()
            ->assertSee($category->name);
    });

    it('can displays products of a category', function (): void {
        /** @var Category $category */
        $category = Category::factory()->create([
            'slug' => 'homme',
            'is_enabled' => true,
        ]);

        $products = Product::factory([
            'published_at' => now()->subDay(),
            'is_visible' => true,
        ])->count(3)->create();

        foreach ($products as $product) {
            $product->categories()->attach($category->id);
        }

        Livewire::test(CategoryProducts::class, ['category' => $category])
            ->assertSuccessful()
            ->assertSee($products[0]->name)
            ->assertSee($products[1]->name)
            ->assertSee($products[2]->name);
    });
});
