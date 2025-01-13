<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductVariant;
use Darryldecode\Cart\Facades\CartFacade;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class VariantsSelector extends Component
{
    public Product $product;

    public ?ProductVariant $selectedVariant = null;

    public function mount(): void
    {
        $this->selectedVariant?->loadMissing([
            'prices' => function ($query) {
                $query->whereRelation('currency', 'code', current_currency());
            },
            'prices.currency',
        ]);

    }

    public function addToCart(): void
    {
        $model = $this->selectedVariant ?? $this->product;

        // @phpstan-ignore-next-line
        CartFacade::session(session()->getId())->add([
            'id' => $model->id,
            'name' => $this->product->name,
            'price' => $model->getPrice()->amount->amount,
            'quantity' => 1,
            'attributes' => $this->selectedVariant
                ? $this->selectedVariant->values->mapWithKeys(function ($value) {
                    return [$value->attribute->name => $value->value];
                })->toArray()
                : [],
            'associatedModel' => $model,
        ]);

        $this->dispatch('cartUpdated');

        Notification::make()
            ->title(__('Cart updated'))
            ->body(__('Product / variant has been added to your cart'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.components.variants-selector');
    }
}
