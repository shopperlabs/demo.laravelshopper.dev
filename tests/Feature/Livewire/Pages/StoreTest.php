<?php

declare(strict_types=1);

use App\Livewire\Pages\Store;
use App\Models\Product;
use Livewire\Livewire;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;

use function Pest\Laravel\get;

beforeEach(function (): void {
    $this->product = Product::factory([
        'slug' => 'red-shirt',
        'is_visible' => true,
        'published_at' => now()->subDay(),
    ])->create();
    $this->secondProduct = Product::factory([
        'name' => 'Blue Large Shirt',
        'slug' => 'blue-shirt',
    ])->create();
});
describe(Store::class, function (): void {
    it('can render store page', function (): void {
        get(route('store.products'))->assertOk();

        Livewire::test(Store::class)
            ->assertSuccessful();
    });

    it('can filters products', function () {
        $colorAttribute = Attribute::query()->create(['name' => 'Color', 'slug' => 'color', 'type' => 'checkbox']);
        $redAttributeValue = AttributeValue::query()->create(['value' => 'Red', 'key' => '#1e3a8a', 'attribute_id' => $colorAttribute->id]);
        $blueAttributeValue = AttributeValue::query()->create(['value' => 'Blue', 'key' => '#ddf048', 'attribute_id' => $colorAttribute->id]);
        $sizeAttribute = Attribute::query()->create(['name' => 'Size', 'slug' => 'size', 'type' => 'checkbox']);
        $smallAttributeValue = AttributeValue::query()->create(['value' => 'Small', 'key' => 'XL', 'attribute_id' => $sizeAttribute->id]);
        $largeAttributeValue = AttributeValue::query()->create(['value' => 'Large', 'key' => 'L', 'attribute_id' => $sizeAttribute->id]);

        $this->product->attributes()->createMany([
            ['attribute_value_id' => $redAttributeValue->id, 'attribute_id' => $colorAttribute->id],
            ['attribute_value_id' => $smallAttributeValue->id, 'attribute_id' => $sizeAttribute->id],
        ]);

        $this->secondProduct->attributes()->createMany([
            ['attribute_value_id' => $blueAttributeValue->id, 'attribute_id' => $colorAttribute->id],
            ['attribute_value_id' => $largeAttributeValue->id, 'attribute_id' => $sizeAttribute->id],
        ]);

        Livewire::test(Store::class)
            ->set('selectedAttributes', [
                $smallAttributeValue->id,
            ])
            ->assertSee(route('single-product', ['product' => $this->product]))
            ->assertDontSee(route('single-product', ['product' => $this->secondProduct]));
    });
});
