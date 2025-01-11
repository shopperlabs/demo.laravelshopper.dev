<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
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
                    'prices' => function ($query) {
                        $query->whereRelation('currency', 'code', current_currency());
                    },
                    'prices.currency',
                ])
                ->scopes('publish')
                ->limit(8)
                ->get(),
            'collections' => Collection::query()->withCount('products')
                ->with('media')
                ->select('id', 'name', 'slug', 'description')
                ->limit(3)
                ->get()
                ->sortBy(['products_count', 'desc']),
            'categories' => Category::withRecursiveQueryConstraint(
                constraint: function (Builder $query): void {
                    $query->where(shopper_table('categories') . '.is_enabled', true);
                },
                query: fn () => Category::with('media')->tree()->get()
            ),
        ]);
    }
}
