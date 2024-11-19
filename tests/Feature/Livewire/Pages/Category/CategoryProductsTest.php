<?php

declare(strict_types=1);

use Livewire\Livewire;
use App\Models\Product;
use App\Models\Category;

use function Pest\Laravel\get;
use App\Livewire\Pages\Category\CategoryProducts;


describe(CategoryProducts::class, function (): void {
    it('can render category products page', function (): void {
        $category = Category::factory()->create([
            'slug' => 'homme',
        ]);

        get(route('category.products', $category->slug))->assertOk();

        Livewire::test(CategoryProducts::class, ['slug' => $category->slug])
            ->assertSuccessful()
            ->assertSee($category->name);
    });

    it('can displays products of a category', function (): void {
        $category = Category::factory()->create([
            'slug' => 'homme',
        ]);
    
        $products = Product::factory()->count(3)->create();
    
        foreach ($products as $product) {
            $product->categories()->attach($category->id);
        }
    
        Livewire::test(CategoryProducts::class, ['slug' => $category->slug])
            ->assertSuccessful()
            ->assertSee($products[0]->name)
            ->assertSee($products[1]->name)
            ->assertSee($products[2]->name);
    });
});