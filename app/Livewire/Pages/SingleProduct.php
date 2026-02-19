<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

final class SingleProduct extends Component
{
    public Product $product;

    public ?ProductVariant $selectedVariant = null;

    public float $averageRating = 0;

    #[Url(except: '')]
    public string $variant = '';

    public function mount(): void
    {
        abort_unless($this->product->isPublished(), 404);

        $currencyCode = current_currency();

        $priceConstraint = function ($query) use ($currencyCode): void {
            $query->whereRelation('currency', 'code', $currencyCode);
        };

        $this->product->load([
            'brand',
            'media',
            'categories',
            'variants.media',
            'variants.values.attribute',
            'variants.prices' => $priceConstraint,
            'relatedProducts.brand',
            'relatedProducts.media',
            'relatedProducts.prices' => $priceConstraint,
            'prices' => $priceConstraint,
        ]);

        $this->averageRating = (float) ($this->product->averageRating(1)->first());

        ProductVariant::loadCurrentStock($this->product->variants); // @phpstan-ignore argument.type

        $this->selectedVariant = filled($this->variant) // @phpstan-ignore assign.propertyType
            ? $this->product->variants->find($this->variant)?->loadMissing('media')
            : null;

        abort_if($this->variant && ! $this->selectedVariant, 404);
    }

    #[On('variantSelected')]
    public function onVariantSelected(?int $variantId): void
    {
        $this->variant = $variantId ? (string) $variantId : '';

        if ($variantId) {
            $currencyCode = current_currency();

            $this->selectedVariant = ProductVariant::with([
                'media',
                'prices' => fn ($q) => $q->whereRelation('currency', 'code', $currencyCode),
            ])->find($variantId);

            if ($this->selectedVariant) {
                ProductVariant::loadCurrentStock(new Collection([$this->selectedVariant])); // @phpstan-ignore argument.type
            }
        } else {
            $this->selectedVariant = null;
        }

        $this->ensureProductRelationsLoaded();
    }

    public function render(): View
    {
        $this->ensureProductRelationsLoaded();

        return view('livewire.pages.single-product', [
            'selectedVariant' => $this->selectedVariant,
        ])
            ->title($this->product->name);
    }

    private function ensureProductRelationsLoaded(): void
    {
        $currencyCode = current_currency();
        $priceConstraint = fn ($q) => $q->whereRelation('currency', 'code', $currencyCode);

        $this->product->loadMissing([
            'brand',
            'media',
            'prices' => $priceConstraint,
            'relatedProducts.brand',
            'relatedProducts.media',
            'relatedProducts.prices' => $priceConstraint,
        ]);

        if ($this->selectedVariant instanceof ProductVariant) {
            $this->selectedVariant->loadMissing([
                'prices' => $priceConstraint,
            ]);
        }
    }
}
