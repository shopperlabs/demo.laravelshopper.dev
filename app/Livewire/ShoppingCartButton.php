<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Shopper\Cart\CartSessionManager;

final class ShoppingCartButton extends Component
{
    public int $cartTotalItems = 0;

    public function mount(): void
    {
        $this->updateCount();
    }

    #[On('cartUpdated')]
    public function updateCount(): void
    {
        $cart = app(CartSessionManager::class)->current();

        $this->cartTotalItems = $cart?->lines->sum('quantity') ?? 0;
    }

    public function render(): View
    {
        return view('livewire.shopping-cart-button');
    }
}
