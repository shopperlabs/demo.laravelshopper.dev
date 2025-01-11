<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

final class SingleProduct extends Component
{
    public Product $product;

    #[Url(except: '')]
    public string $variant = '';

    public function mount(): void
    {
        abort_unless($this->product->isPublished(), 404);

        $this->product->load([
            'brand',
            'media',
            'relatedProducts',
            'prices' => function ($query) {
                $query->whereRelation('currency', 'code', current_currency());
            },
            'prices.currency',
        ]);
    }

    #[Computed]
    public function averageRating(): float
    {
        return floatval($this->product->averageRating(1)->first());
    }

    public function render(): View
    {
        return view('livewire.pages.single-product', [
            'selectedVariant' => null,
        ])
            ->title($this->product->name);
    }
}
