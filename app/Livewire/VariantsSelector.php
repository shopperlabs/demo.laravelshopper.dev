<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\Cart\AddToCart;
use App\Actions\Product\BuildVariantOptions;
use App\Actions\Product\ResolveVariantAvailability;
use App\Models\Product;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Contracts\View\View;
use InvalidArgumentException;
use Livewire\Component;

final class VariantsSelector extends Component
{
    public Product $product;

    public ?ProductVariant $selectedVariant = null;

    /**
     * attribute_id => value_id
     *
     * @var array<int, int>
     */
    public array $selectedOptions = [];

    public bool $hasStructuredAttributes = false;

    /**
     * @var array<int, array{
     *     id: int,
     *     name: string,
     *     slug: string,
     *     type: string,
     *     values: array<int, array{id: int, value: string, key: string, image: ?string}>
     * }>
     */
    public array $productOptions = [];

    /**
     * @var array<int, array{
     *     id: int,
     *     values: array<int, int>,
     *     stock: int,
     *     allow_backorder: bool
     * }>
     */
    public array $variantMap = [];

    /**
     * sorted_value_ids_key => variant_id
     *
     * @var array<string, int>
     */
    public array $variantIndex = [];

    /**
     * attribute_id => [value_id => available]
     *
     * @var array<int, array<int, bool>>
     */
    public array $availabilityMap = [];

    /**
     * @throws Exception
     */
    public function mount(): void
    {
        $options = resolve(BuildVariantOptions::class)->handle($this->product);

        $this->productOptions = $options['productOptions'];
        $this->variantIndex = $options['variantIndex'];
        $this->variantMap = $options['variantMap'];
        $this->hasStructuredAttributes = $options['hasStructuredAttributes'];
        $this->availabilityMap = $options['availabilityMatrix'];

        if ($this->selectedVariant instanceof ProductVariant) {
            $this->prefillSelectedOptions();
        } elseif ($this->product->variants->count() === 1) {
            $this->selectedVariant = $this->product->variants->first(); // @phpstan-ignore assign.propertyType
            $this->prefillSelectedOptions();
        }
    }

    /**
     * @throws Exception
     */
    public function selectOption(int $attributeId, int $valueId): void
    {
        if (($this->selectedOptions[$attributeId] ?? null) === $valueId) {
            unset($this->selectedOptions[$attributeId]);
        } else {
            $this->selectedOptions[$attributeId] = $valueId;
        }

        $this->resolveVariant();

        $this->availabilityMap = resolve(ResolveVariantAvailability::class)->handle(
            $this->variantMap,
            $this->selectedOptions,
            $this->productOptions,
        );
    }

    public function selectVariantDirectly(int $variantId): void
    {
        $variant = $this->product->variants->find($variantId);

        if (! $variant) {
            return;
        }

        $this->selectedVariant = $variant; // @phpstan-ignore assign.propertyType
        $this->dispatch('variantSelected', variantId: $variant->id);
    }

    /**
     * @throws Exception
     */
    public function addToCart(): void
    {
        try {
            resolve(AddToCart::class)->handle($this->product, $this->selectedVariant);
        } catch (InvalidArgumentException $e) {
            $this->dispatch('notify', type: 'error', title: __('Error'), message: $e->getMessage());

            return;
        }

        $this->dispatch('cartUpdated');
        $this->dispatch('notify', type: 'success', title: __('Cart updated'), message: __('Product / variant has been added to your cart'));
    }

    public function render(): View
    {
        return view('livewire.components.variants-selector');
    }

    private function prefillSelectedOptions(): void
    {
        if (! $this->selectedVariant instanceof ProductVariant) {
            return;
        }

        $this->selectedVariant->loadMissing('values');

        foreach ($this->selectedVariant->values as $value) {
            $this->selectedOptions[$value->attribute_id] = $value->id;
        }
    }

    private function resolveVariant(): void
    {
        if (count($this->selectedOptions) !== count($this->productOptions)) {
            $this->selectedVariant = null;
            $this->dispatch('variantSelected', variantId: null);

            return;
        }

        $selectedValueIds = collect($this->selectedOptions)->values()->sort()->values()->all();
        $key = implode('-', $selectedValueIds);

        $variantId = $this->variantIndex[$key] ?? null;

        if ($variantId) {
            $this->selectedVariant = $this->product->variants->find($variantId); // @phpstan-ignore assign.propertyType
            $this->dispatch('variantSelected', variantId: $variantId);
        } else {
            $this->selectedVariant = null;
            $this->dispatch('variantSelected', variantId: null);
        }
    }
}
