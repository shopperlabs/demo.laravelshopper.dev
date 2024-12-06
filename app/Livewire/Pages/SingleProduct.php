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

    public function mount(Product $product): void
    {
        abort_unless($product->isPublished(), 404);

        $this->product = $product->load([
            'media',
            'relatedProducts',
            'variants',
            'variants.media',
        ]);
    }

    #[Computed]
    public function getAverageRatingProperty(): float
    {
        return floatval($this->product->averageRating(1)->first());
    }

    public function render(): View
    {
        return view('livewire.pages.single-product', [
            'selectedVariant' => Product::with('media')
                ->where('slug', $this->variant)
                ->select('name', 'slug', 'sku', 'id', 'price_amount', 'old_price_amount')
                ->first(),
        ])
            ->title($this->product->name);
    }
}
