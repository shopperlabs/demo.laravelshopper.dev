<?php

declare(strict_types=1);

namespace App\Livewire;

use Darryldecode\Cart\CartCollection;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Contracts\View\View;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\On;

final class ShoppingCart extends SlideOverComponent
{
    public float $subtotal = 0;

    public CartCollection $items;

    public ?string $sessionKey = null;

    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    public function mount(): void
    {
        $sessionKey = session()->getId();

        $this->sessionKey = $sessionKey;
        $this->items = CartFacade::session($sessionKey)->getContent(); // @phpstan-ignore-line
        $this->subtotal = CartFacade::session($sessionKey)->getSubTotal(); // @phpstan-ignore-line
    }

    #[On('cartUpdated')]
    public function cartUpdated(): void
    {
        $this->items = CartFacade::session($this->sessionKey)->getContent(); // @phpstan-ignore-line
        $this->subtotal = CartFacade::session($this->sessionKey)->getSubTotal(); // @phpstan-ignore-line
    }

    public function removeToCart(int $id): void
    {
        CartFacade::session($this->sessionKey)->remove($id); // @phpstan-ignore-line

        $this->dispatch('notify', type: 'success', title: __('Cart updated'), message: __('The product has been removed from your cart!'));

        $this->dispatch('cartUpdated');
    }

    public function render(): View
    {
        return view('livewire.shopping-cart');
    }
}
