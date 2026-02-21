<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Core\Models\Attribute;

class Store extends Component
{
    use WithPagination;

    public const string FILTERABLE_ATTRIBUTES_CACHE_KEY = 'filterable_attributes';

    public const int FILTERABLE_ATTRIBUTES_CACHE_TTL = 7200;

    /** @var array<string, string[]> */
    #[Url(as: 'filters')]
    public array $selectedAttributes = [];

    /**
     * @return Collection<int, Attribute>
     */
    #[Computed]
    public function options(): Collection
    {
        return Cache::remember(
            key: self::FILTERABLE_ATTRIBUTES_CACHE_KEY,
            ttl: self::FILTERABLE_ATTRIBUTES_CACHE_TTL,
            callback: fn (): Collection => Attribute::with('values')
                ->scopes(['enabled', 'isFilterable'])
                ->get()
        );
    }

    public function toggleAttribute(string $slug, string $valueId): void
    {
        if (! isset($this->selectedAttributes[$slug])) {
            $this->selectedAttributes[$slug] = [];
        }

        if (in_array($valueId, $this->selectedAttributes[$slug])) {
            $this->selectedAttributes[$slug] = array_values(
                array_filter($this->selectedAttributes[$slug], fn (string $v): bool => $v !== $valueId)
            );
        } else {
            $this->selectedAttributes[$slug][] = $valueId;
        }

        if (blank($this->selectedAttributes[$slug])) {
            unset($this->selectedAttributes[$slug]);
        }

        $this->resetPage();
    }

    public function render(): View
    {
        $query = Product::query()->publish()
            ->with(['media', 'brand', 'options.values'])
            ->withCurrentPrices()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest();

        $selectedIds = collect($this->selectedAttributes)->flatten()->filter()->all();

        if (count($selectedIds) > 0) {
            $query = $query->whereHas('options', function ($query) use ($selectedIds): void {
                $query->whereIn('attribute_value_id', $selectedIds);
            });
        }

        return view('livewire.pages.store', [
            'products' => $query->paginate(20),
        ]);
    }
}
