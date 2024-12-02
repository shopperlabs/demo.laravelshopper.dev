<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\View\View;
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

    public function render(): View
    {
        $query = Product::with(['media', 'attributes'])
            ->scopes(['parent', 'publish'])
            ->latest();

        if (count($this->selectedAttributes) > 0) {
            $query = $query->whereHas('attributes', function ($query) {
                $query->whereIn('attribute_value_id', $this->selectedAttributes);
            });
        }

        return view('livewire.pages.store', [
            'products' => $query->paginate(12),
            'attributes' => Attribute::with('values')->enabled()->get(),
        ]);
    }
}
