<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

final class SingleProduct extends Component
{
    public Product $product;

    public ?ProductVariant $selectedVariant = null;

    #[Url(except: '')]
    public string $variant = '';

    public function mount(): void
    {
        abort_unless($this->product->isPublished(), 404);

        $this->product->load([
            'brand',
            'media',
            'inventoryHistories',
            'relatedProducts',
            'prices' => function ($query) {
                $query->whereRelation('currency', 'code', current_currency());
            },
            'prices.currency',
        ]);

        $this->selectedVariant = ($this->variant) ? ProductVariant::query()
            ->with(['media'])
            ->where('id', $this->variant)
            ->firstOrFail() : null;
    }

    #[Computed]
    public function averageRating(): float
    {
        return floatval($this->product->averageRating(1)->first());
    }

    public function render(): View
    {
        return view('livewire.pages.single-product', [
            'selectedVariant' => $this->selectedVariant,
        ])
            ->title($this->product->name);
    }
}
