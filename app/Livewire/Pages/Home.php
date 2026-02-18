<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopper\Core\Models\Collection;

final class Home extends Component
{
    public function render(): View
    {
        return view('livewire.pages.home', [
            'products' => Product::query()
                ->select('id', 'name', 'slug', 'brand_id')
                ->with([
                    'brand',
                    'media',
                    'prices' => function ($query): void {
                        $query->whereRelation('currency', 'code', current_currency());
                    },
                    'prices.currency',
                ])
                ->where('featured', true)
                ->scopes('publish')
                ->limit(8)
                ->get(),
            'collections' => Collection::query()
                ->has('products')
                ->withCount('products')
                ->with('media')
                ->orderByDesc('products_count')
                ->limit(3)
                ->get(),
            'categories' => Category::query()
                ->whereNull('parent_id')
                ->where('is_enabled', true)
                ->has('products')
                ->withCount(['products' => fn ($query) => $query->whereNull('sh_products.deleted_at')])
                ->orderByDesc('products_count')
                ->with(['media', 'children'])
                ->limit(4)
                ->get(),
        ]);
    }
}
