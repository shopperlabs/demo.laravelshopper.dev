<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Product;

use App\Models\Product;
use Illuminate\Contracts\View\View;
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

    public function render(): View
    {
        return view('livewire.pages.single-product', [
            'selectedVariant' => Product::with('media')
                ->where('slug', $this->variant)
                ->select('name', 'slug', 'sku', 'id', 'price_amount', 'old_price_amount')
                ->first(),
        ]);
}
