<?php

declare(strict_types=1);

use App\Livewire\VariantsSelector;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Livewire\Livewire;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Enum\ProductType;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;
use Shopper\Core\Models\Inventory;

beforeEach(function (): void {
    $this->product = Product::factory()->create([
        'name' => 'Test T-Shirt',
        'type' => ProductType::Variant,
    ]);

    $this->colorAttr = Attribute::query()->create([
        'name' => 'Color',
        'slug' => 'color',
        'type' => FieldType::ColorPicker,
        'is_enabled' => true,
    ]);

    $this->sizeAttr = Attribute::query()->create([
        'name' => 'Size',
        'slug' => 'size',
        'type' => FieldType::Checkbox,
        'is_enabled' => true,
    ]);

    $this->blue = AttributeValue::query()->create([
        'value' => 'Blue',
        'key' => '#1e3a8a',
        'position' => 1,
        'attribute_id' => $this->colorAttr->id,
    ]);

    $this->red = AttributeValue::query()->create([
        'value' => 'Red',
        'key' => '#dc2626',
        'position' => 2,
        'attribute_id' => $this->colorAttr->id,
    ]);

    $this->small = AttributeValue::query()->create([
        'value' => 'S',
        'key' => 's',
        'position' => 1,
        'attribute_id' => $this->sizeAttr->id,
    ]);

    $this->large = AttributeValue::query()->create([
        'value' => 'L',
        'key' => 'l',
        'position' => 2,
        'attribute_id' => $this->sizeAttr->id,
    ]);

    $this->actingAs(User::factory()->create());

    $this->inventory = Inventory::factory()->create(['is_default' => true]);

    // Blue / S - in stock (10 units)
    $this->variantBlueS = ProductVariant::factory()->create([
        'name' => 'Blue / S',
        'product_id' => $this->product->id,
    ]);
    $this->variantBlueS->values()->attach([$this->blue->id, $this->small->id]);
    $this->variantBlueS->mutateStock($this->inventory->id, 10);

    // Blue / L - out of stock
    $this->variantBlueL = ProductVariant::factory()->create([
        'name' => 'Blue / L',
        'product_id' => $this->product->id,
    ]);
    $this->variantBlueL->values()->attach([$this->blue->id, $this->large->id]);

    // Red / S - in stock (5 units)
    $this->variantRedS = ProductVariant::factory()->create([
        'name' => 'Red / S',
        'product_id' => $this->product->id,
    ]);
    $this->variantRedS->values()->attach([$this->red->id, $this->small->id]);
    $this->variantRedS->mutateStock($this->inventory->id, 5);

    // Red / L - out of stock
    $this->variantRedL = ProductVariant::factory()->create([
        'name' => 'Red / L',
        'product_id' => $this->product->id,
    ]);
    $this->variantRedL->values()->attach([$this->red->id, $this->large->id]);

    $this->product->load('variants.values.attribute');
    ProductVariant::loadCurrentStock($this->product->variants);
});

describe(VariantsSelector::class, function (): void {
    it('renders with structured attributes', function (): void {
        Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ])
            ->assertSuccessful()
            ->assertSee('Color')
            ->assertSee('Size');
    });

    it('groups options by attribute', function (): void {
        $component = Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ]);

        expect($component->get('hasStructuredAttributes'))->toBeTrue()
            ->and($component->get('productOptions'))->toHaveCount(2);
    });

    it('selects an option and updates state', function (): void {
        Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ])
            ->call('selectOption', $this->colorAttr->id, $this->blue->id)
            ->assertSet('selectedOptions.'.$this->colorAttr->id, $this->blue->id)
            ->assertSet('selectedVariant', null);
    });

    it('resolves variant when all options are selected', function (): void {
        Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ])
            ->call('selectOption', $this->colorAttr->id, $this->blue->id)
            ->call('selectOption', $this->sizeAttr->id, $this->small->id)
            ->assertSet('selectedVariant.id', $this->variantBlueS->id)
            ->assertDispatched('variantSelected', variantId: $this->variantBlueS->id);
    });

    it('dispatches null when selection is incomplete', function (): void {
        Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ])
            ->call('selectOption', $this->colorAttr->id, $this->blue->id)
            ->assertDispatched('variantSelected', variantId: null);
    });

    it('toggles option off when clicking same value', function (): void {
        Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ])
            ->call('selectOption', $this->colorAttr->id, $this->blue->id)
            ->assertSet('selectedOptions.'.$this->colorAttr->id, $this->blue->id)
            ->call('selectOption', $this->colorAttr->id, $this->blue->id)
            ->assertSet('selectedOptions.'.$this->colorAttr->id, null);
    });

    it('detects out of stock options via availability map', function (): void {
        $component = Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ]);

        $availabilityMap = $component->get('availabilityMap');

        // Large is out of stock for both colors
        expect($availabilityMap[$this->sizeAttr->id][$this->large->id])->toBeFalse()
            ->and($availabilityMap[$this->sizeAttr->id][$this->small->id])->toBeTrue();
    });

    it('updates availability map based on current selection', function (): void {
        $component = Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ])
            ->call('selectOption', $this->colorAttr->id, $this->blue->id);

        $availabilityMap = $component->get('availabilityMap');

        // Blue / S is in stock, Blue / L is not
        expect($availabilityMap[$this->sizeAttr->id][$this->small->id])->toBeTrue()
            ->and($availabilityMap[$this->sizeAttr->id][$this->large->id])->toBeFalse();
    });

    it('prefills options when variant is passed', function (): void {
        Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
            'selectedVariant' => $this->variantBlueS,
        ])
            ->assertSet('selectedOptions.'.$this->colorAttr->id, $this->blue->id)
            ->assertSet('selectedOptions.'.$this->sizeAttr->id, $this->small->id)
            ->assertSet('selectedVariant.id', $this->variantBlueS->id);
    });

    it('shows button as disabled when no variant is selected', function (): void {
        Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ])
            ->assertSee(__('Choose any variant'));
    });

    it('falls back to flat grid for variants without attributes', function (): void {
        $simpleProduct = Product::factory()->create([
            'name' => 'Simple Shoes',
            'type' => ProductType::Variant,
        ]);

        $v1 = ProductVariant::factory()->create(['name' => '40', 'product_id' => $simpleProduct->id]);
        $v2 = ProductVariant::factory()->create(['name' => '41', 'product_id' => $simpleProduct->id]);

        $simpleProduct->load(['variants.values.attribute', 'variants.prices.currency']);
        ProductVariant::loadCurrentStock($simpleProduct->variants);

        $component = Livewire::test(VariantsSelector::class, [
            'product' => $simpleProduct,
        ]);

        expect($component->get('hasStructuredAttributes'))->toBeFalse();

        $component->assertSee('40')->assertSee('41');
    });

    it('selects variant directly in flat mode', function (): void {
        $simpleProduct = Product::factory()->create([
            'name' => 'Simple Shoes',
            'type' => ProductType::Variant,
        ]);

        $v1 = ProductVariant::factory()->create(['name' => '40', 'product_id' => $simpleProduct->id]);
        $simpleProduct->load(['variants.values.attribute', 'variants.prices.currency']);
        ProductVariant::loadCurrentStock($simpleProduct->variants);

        Livewire::test(VariantsSelector::class, [
            'product' => $simpleProduct,
        ])
            ->call('selectVariantDirectly', $v1->id)
            ->assertSet('selectedVariant.id', $v1->id)
            ->assertDispatched('variantSelected', variantId: $v1->id);
    });

    it('builds variant index for O(1) lookup', function (): void {
        $component = Livewire::test(VariantsSelector::class, [
            'product' => $this->product,
        ]);

        $variantIndex = $component->get('variantIndex');

        // Should have 4 entries (4 variants)
        expect($variantIndex)->toHaveCount(4);

        // Blue/S key should map to the correct variant
        $blueSmallKey = collect([$this->blue->id, $this->small->id])->sort()->values()->implode('-');
        expect($variantIndex[$blueSmallKey])->toBe($this->variantBlueS->id);
    });
});
