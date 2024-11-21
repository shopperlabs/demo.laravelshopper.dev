<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Core\Models\Attribute;

class Store extends Component
{
    use WithPagination;

    public Collection $atributes;

    private $products;

    public $selectedAttributes = [];

    public function mount(): void
    {
        $this->filterProducts();
        $this->atributes = Attribute::with('values')->where('is_enabled', true)->get();
    }

    public function filterProducts(): void
    {
        $this->products = Product::with(['media'])->parent();
        foreach ($this->selectedAttributes as $attributeId => $valueIds) {
            $this->products = $this->products->whereHas('attributes', function ($query) use ($attributeId, $valueIds) {
                if (is_array($valueIds) && ! empty($valueIds)) {
                    $query->where('attribute_id', $attributeId)
                        ->whereIn('attribute_value_id', $valueIds);
                }
            });
        }
        $this->products = $this->products->paginate(12);
    }

    public function updatedSelectedAttributes(): void
    {
        $this->filterProducts();
    }

    public function render(): View
    {
        return view('livewire.pages.store', ['products' => $this->products]);
    }
}
