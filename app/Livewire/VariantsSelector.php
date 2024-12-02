<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class VariantsSelector extends Component
{
    public Product $product;

    public ?Product $selectedVariant = null;

    public function addToCart(): void
    {
        // @phpstan-ignore-next-line
        CartFacade::session(session()->getId())->add([
            'id' => $this->selectedVariant ? $this->selectedVariant->id : $this->product->id,
            'name' => $this->selectedVariant
                ? $this->product->name . ' / ' . $this->selectedVariant->name
                : $this->product->name,
            'price' => $this->selectedVariant && $this->selectedVariant->price_amount
                ? $this->selectedVariant->price_amount
                : $this->product->price_amount,
            'quantity' => 1,
            'associatedModel' => $this->selectedVariant?->load('parent') ?? $this->product,
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
