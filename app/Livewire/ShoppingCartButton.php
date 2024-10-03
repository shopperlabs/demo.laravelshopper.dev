<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class ShoppingCartButton extends Component
{
    public int $cartTotalItems = 0;

    #[On('cartUpdated')]
    public function render(): View
    {
        return view('livewire.shopping-cart-button');
    }
}
