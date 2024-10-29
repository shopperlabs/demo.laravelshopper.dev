<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SingleProduct extends Component
{
    public ?Product $product = null;

    public function mount(string $slug): void
    {
        $this->product = Product::with(['brand', 'media', 'attributes', 'relatedProducts'])
            ->scopes('publish')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.pages.single-product')
            ->title($this->product->name);
    }
}
