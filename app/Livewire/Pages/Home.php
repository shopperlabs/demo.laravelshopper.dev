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
        dd(Product::with(['brand', 'media'])
            ->scopes('publish')
            ->get());

        return view('livewire.pages.home', [
            'products' => Product::with(['brand', 'media'])
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
                query: fn () => Category::with('media')->limit(8)->tree()->get()
            ),
        ]);
    }
}
