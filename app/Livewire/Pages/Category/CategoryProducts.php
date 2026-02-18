<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Category;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Core\Models\Category;

final class CategoryProducts extends Component
{
    use WithPagination;

    public Category $category;

    public function mount(): void
    {
        abort_unless($this->category->is_enabled, 404);

        $this->category->loadMissing('children');
    }

    public function render(): View
    {
        return view('livewire.category.category-products', [
            'products' => Product::query()
                ->with([
                    'media',
                    'brand',
                    'prices' => fn ($q) => $q->whereRelation('currency', 'code', current_currency()),
                    'prices.currency',
                ])
                ->scopes('publish')
                ->whereHas('categories', function ($query): void {
                    $query->where('id', $this->category->id);
                })
                ->paginate(20),
        ]);
    }
}
