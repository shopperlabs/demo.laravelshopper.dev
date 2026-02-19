<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Core\Models\Attribute;

class Store extends Component
{
    use WithPagination;

    /**
     * @var string[]
     */
    public array $selectedAttributes = [];

    /**
     * @return Collection<int, Attribute>
     */
    #[Computed]
    public function options(): Collection
    {
        return Attribute::with('values')->scopes(['enabled', 'isFilterable'])->get();
    }

    public function render(): View
    {
        $query = Product::query()->publish()
            ->with(['media', 'brand', 'options.values'])
            ->withCurrentPrices()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest();

        if (count($this->selectedAttributes) > 0) {
            $query = $query->whereHas('options', function ($query): void {
                $query->whereIn('attribute_value_id', $this->selectedAttributes);
            });
        }

        return view('livewire.pages.store', [
            'products' => $query->paginate(20),
        ]);
    }
}
