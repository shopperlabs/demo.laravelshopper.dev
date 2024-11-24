<?php

declare(strict_types=1);

use App\Models\Product;
use Livewire\Livewire;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;

use function Pest\Laravel\get;

describe(\App\Livewire\Pages\Store::class, function (): void {
    it('can render store page', function (): void {
        get(route('store.products'))->assertOk();

        Livewire::test(\App\Livewire\Pages\Store::class)
            ->assertSuccessful();
    });

    it('can filters products', function () {
        $colorAttribute = Attribute::create(['name' => 'Color', 'slug' => 'color', 'type' => 'checkbox']);
        $redAttributeValue = AttributeValue::create(['value' => 'Red', 'key' => '#1e3a8a', 'attribute_id' => $colorAttribute->id]);
        $blueAttributeValue = AttributeValue::create(['value' => 'Blue', 'key' => '#ddf048', 'attribute_id' => $colorAttribute->id]);
        $sizeAttribute = Attribute::create(['name' => 'Size', 'slug' => 'size', 'type' => 'checkbox']);
        $smallAttributeValue = AttributeValue::create(['value' => 'Small', 'key' => 'XL', 'attribute_id' => $sizeAttribute->id]);
        $largeAttributeValue = AttributeValue::create(['value' => 'Large', 'key' => 'L', 'attribute_id' => $sizeAttribute->id]);
        $product1 = Product::factory()->create(['name' => 'Red Small Shirt', 'slug' => 'red-shirt']);
        $product2 = Product::factory()->create(['name' => 'Blue Large Shirt', 'slug' => 'blue-shirt']);

        $product1->attributes()->createMany([
            ['attribute_value_id' => $redAttributeValue->id, 'attribute_id' => $colorAttribute->id],
            ['attribute_value_id' => $smallAttributeValue->id, 'attribute_id' => $sizeAttribute->id],
        ]);

        $product2->attributes()->createMany([
            ['attribute_value_id' => $blueAttributeValue->id, 'attribute_id' => $colorAttribute->id],
            ['attribute_value_id' => $largeAttributeValue->id, 'attribute_id' => $sizeAttribute->id],
        ]);

        Livewire::test(\App\Livewire\Pages\Store::class)
            ->set('selectedAttributes', [
                $sizeAttribute->id => [$smallAttributeValue->id => true],
            ])
            ->call('filterProducts')
            ->assertSee(route('single-product', ['slug' => $product1->slug]))
            ->assertDontSee(route('single-product', ['slug' => $product2->slug]));
    });
});
