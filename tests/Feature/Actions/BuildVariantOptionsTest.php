<?php

declare(strict_types=1);

use App\Actions\Product\BuildVariantOptions;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Enum\ProductType;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;
use Shopper\Core\Models\Inventory;

beforeEach(function (): void {
    $this->actingAs(User::factory()->create());

    $this->product = Product::factory()->create([
        'name' => 'Test Phone',
        'type' => ProductType::Variant,
    ]);

    $this->colorAttr = Attribute::query()->create([
        'name' => 'Color',
        'slug' => 'color',
        'type' => FieldType::ColorPicker,
        'is_enabled' => true,
    ]);

    $this->sizeAttr = Attribute::query()->create([
        'name' => 'Storage',
        'slug' => 'storage',
        'type' => FieldType::Checkbox,
        'is_enabled' => true,
    ]);

    $this->blue = AttributeValue::query()->create([
        'value' => 'Blue',
        'key' => '#1e3a8a',
        'position' => 1,
        'attribute_id' => $this->colorAttr->id,
    ]);

    $this->small = AttributeValue::query()->create([
        'value' => '128 GB',
        'key' => '128gb',
        'position' => 1,
        'attribute_id' => $this->sizeAttr->id,
    ]);

    $this->inventory = Inventory::factory()->create(['is_default' => true]);

    $this->variant = ProductVariant::factory()->create([
        'name' => 'Blue / 128 GB',
        'product_id' => $this->product->id,
    ]);
    $this->variant->values()->attach([$this->blue->id, $this->small->id]);
    $this->variant->mutateStock($this->inventory->id, 5);

    $this->product->load('variants.values.attribute');
    ProductVariant::loadCurrentStock($this->product->variants);
});

describe(BuildVariantOptions::class, function (): void {
    it('returns all expected keys', function (): void {
        $result = resolve(BuildVariantOptions::class)->handle($this->product);

        expect($result)->toHaveKeys([
            'productOptions',
            'variantIndex',
            'variantMap',
            'hasStructuredAttributes',
            'availabilityMatrix',
        ]);
    });

    it('builds product options grouped by attribute', function (): void {
        $result = resolve(BuildVariantOptions::class)->handle($this->product);

        expect($result['productOptions'])->toHaveCount(2)
            ->and($result['hasStructuredAttributes'])->toBeTrue();

        $colorOption = collect($result['productOptions'])->firstWhere('slug', 'color');
        expect($colorOption['values'])->toHaveCount(1)
            ->and($colorOption['values'][0]['value'])->toBe('Blue');
    });

    it('builds variant index for O(1) lookup', function (): void {
        $result = resolve(BuildVariantOptions::class)->handle($this->product);

        $key = collect([$this->blue->id, $this->small->id])->sort()->values()->implode('-');

        expect($result['variantIndex'])->toHaveCount(1)
            ->and($result['variantIndex'][$key])->toBe($this->variant->id);
    });

    it('builds variant map with stock info', function (): void {
        $result = resolve(BuildVariantOptions::class)->handle($this->product);

        expect($result['variantMap'])->toHaveCount(1)
            ->and($result['variantMap'][0]['stock'])->toBe(5)
            ->and($result['variantMap'][0]['id'])->toBe($this->variant->id);
    });

    it('computes initial availability matrix', function (): void {
        $result = resolve(BuildVariantOptions::class)->handle($this->product);

        expect($result['availabilityMatrix'][$this->colorAttr->id][$this->blue->id])->toBeTrue()
            ->and($result['availabilityMatrix'][$this->sizeAttr->id][$this->small->id])->toBeTrue();
    });

    it('returns empty structured data for variants without attributes', function (): void {
        $product = Product::factory()->create([
            'name' => 'Simple Shoes',
            'type' => ProductType::Variant,
        ]);

        ProductVariant::factory()->create(['name' => '40', 'product_id' => $product->id]);
        $product->load('variants.values.attribute');

        $result = resolve(BuildVariantOptions::class)->handle($product);

        expect($result['hasStructuredAttributes'])->toBeFalse()
            ->and($result['productOptions'])->toBeEmpty()
            ->and($result['availabilityMatrix'])->toBeEmpty();
    });
});
