<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Collection;

use App\Models\Collection;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CollectionProducts extends Component
{
    public Collection $collection;

    public function mount(string $slug): void
    {
        $this->collection = Collection::with('products')->where('slug', $slug)->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.collection.collection-products', ['products' => $this->collection->products]);
    }
}
