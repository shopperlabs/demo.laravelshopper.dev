<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Collection;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Core\Models\Collection;

class CollectionProducts extends Component
{
    use WithPagination;

    public Collection $collection;

    public function render(): View
    {
        return view('livewire.collection.collection-products', [
            'products' => Product::query()
                ->with([
                    'media',
                    'brand',
                    'prices' => fn ($q) => $q->whereRelation('currency', 'code', current_currency()),
                    'prices.currency',
                ])
                ->scopes('publish')
                ->whereHas('collections', function ($query): void {
                    $query->where('id', $this->collection->id);
                })
                ->paginate(20),
        ]);
    }
}
