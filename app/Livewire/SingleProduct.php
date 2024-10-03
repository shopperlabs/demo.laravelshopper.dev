<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SingleProduct extends Component
{
    public ?Product $product = null;

    public function mount(string $slug): void
    {
        $this->product = Product::with(['brand', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.product')
            ->title($this->product->name);
    }
}
