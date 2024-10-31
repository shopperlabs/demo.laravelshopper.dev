<?php

declare(strict_types=1);

namespace App\Livewire;

use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class ShoppingCartButton extends Component
{
    public int $cartTotalItems = 0;

    public ?string $sessionKey = null;

    public function mount(): void
    {
        $this->sessionKey = session()->getId();
        $this->cartTotalItems = CartFacade::session($this->sessionKey)->getTotalQuantity();
    }

    #[On('cartUpdated')]
    public function cartUpdated(): void
    {
        $this->cartTotalItems = CartFacade::session($this->sessionKey)->getTotalQuantity();
    }

    public function render(): View
    {
        return view('livewire.shopping-cart-button');
    }
}
