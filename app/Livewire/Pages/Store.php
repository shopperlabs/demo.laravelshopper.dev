<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Core\Models\Attribute;

class Store extends Component
{
    use WithPagination;

    public Collection $atributes;

    /** @var string[] */
    public array $selectedAttributes = [];

    public function mount(): void
    {
        $this->atributes = Attribute::with('values')->enabled()->get();
        $this->filterProducts();
    }

    public function filterProducts(): LengthAwarePaginator
    {
        $query = Product::with(['media', 'attributes'])->parent();
        if (! empty($this->selectedAttributes)) {
            foreach ($this->selectedAttributes as $attributeId => $valueIds) {
                $selectedValueIds = array_keys(array_filter(array_map(function ($value) {
                    return $value;
                }, $valueIds))); // @phpstan-ignore-line
                if (! empty($selectedValueIds)) {
                    $query = $query->whereHas('attributes', function ($query) use ($attributeId, $selectedValueIds) {
                        $query->where('attribute_id', $attributeId)
                            ->whereIn('attribute_value_id', $selectedValueIds);
                    });
                }
            }
        }

        return $query->paginate(12);
    }

    public function updatedSelectedAttributes(): void
    {
        $this->filterProducts();
    }

    public function render(): View
    {
        return view('livewire.pages.store', ['products' => $this->filterProducts()]);
    }
}
