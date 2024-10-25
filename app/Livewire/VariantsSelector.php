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

    public function addToCart(): void
    {
        $this->product->loadMissing('media');

        CartFacade::session(session()->getId())->add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price_amount,
            'quantity' => 1,
            'attributes' => [],
            'associatedModel' => $this->product,
        ]);

        $this->dispatch('cartUpdated');

        Notification::make()
            ->title(__('Cart updated'))
            ->body(__('Product has been added to cart'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.components.variants-selector');
    }
}
