<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Collection;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopper\Core\Models\Collection;

class CollectionProducts extends Component
{
    public Collection $collection;

    public function render(): View
    {
        return view('livewire.collection.collection-products', [
            'products' => Product::with('media', 'collections')
                ->scopes('publish')
                ->whereHas('collections', function ($query): void {
                    $query->where('id', $this->collection->id);
                })
                ->get(),
        ]);
    }
}
