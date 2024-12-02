<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Category;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopper\Core\Models\Category as ShopperCategory;

final class CategoryProducts extends Component
{
    public ShopperCategory $category;

    public function mount(): void
    {
        abort_unless($this->category->is_enabled, 404);
    }

    public function render(): View
    {
        return view('livewire.category.category-products', [
            'products' => Product::with('media', 'categories')
                ->scopes('publish')
                ->whereHas('categories', function ($query): void {
                    $query->where('id', $this->category->id);
                })
                ->get(),
        ]);
    }
}
