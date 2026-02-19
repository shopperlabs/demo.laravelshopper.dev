<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Shopper\Core\Models\Collection;

final class Home extends Component
{
    public const int CACHE_TTL = 7200;

    public function render(): View
    {
        $currencyCode = current_currency();

        return view('livewire.pages.home', [
            'products' => Cache::remember(
                key: "home_featured_products_{$currencyCode}",
                ttl: self::CACHE_TTL,
                callback: fn (): EloquentCollection => Product::query()
                    ->select('id', 'name', 'slug', 'brand_id')
                    ->with(['brand', 'media'])
                    ->withCurrentPrices()
                    ->where('featured', true)
                    ->scopes('publish')
                    ->limit(8)
                    ->get()
            ),
            'collections' => Cache::remember(
                key: 'home_collections',
                ttl: self::CACHE_TTL,
                callback: fn (): EloquentCollection => Collection::query()
                    ->has('products')
                    ->withCount('products')
                    ->with('media')
                    ->orderByDesc('products_count')
                    ->limit(3)
                    ->get()
            ),
            'categories' => Cache::remember(
                key: 'home_categories',
                ttl: self::CACHE_TTL,
                callback: fn (): EloquentCollection => Category::query()
                    ->whereNull('parent_id')
                    ->where('is_enabled', true)
                    ->has('products')
                    ->withCount(['products' => fn ($query) => $query->whereNull('sh_products.deleted_at')])
                    ->orderByDesc('products_count')
                    ->with(['media', 'children'])
                    ->limit(4)
                    ->get()
            ),
        ]);
    }
}
