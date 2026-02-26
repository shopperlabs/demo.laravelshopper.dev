<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\On;
use Shopper\Cart\CartManager;
use Shopper\Cart\CartSessionManager;
use Shopper\Cart\Models\CartLine;

final class ShoppingCart extends SlideOverComponent
{
    public int $subtotal = 0;

    /** @var Collection<int, CartLine> */
    public Collection $items;

    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    public function mount(): void
    {
        $this->loadCart();
    }

    #[On('cartUpdated')]
    public function loadCart(): void
    {
        $cart = app(CartSessionManager::class)->current();

        if (! $cart) {
            $this->items = collect();
            $this->subtotal = 0;

            return;
        }

        $cart->load('lines.purchasable');
        $cart->lines->loadMorph('purchasable', [
            ProductVariant::class => ['product'],
        ]);
        $this->items = $cart->lines;

        $context = app(CartManager::class)->calculate($cart);
        $this->subtotal = $context->subtotal;
    }

    public function removeFromCart(int $lineId): void
    {
        $cart = cartSession();

        app(CartManager::class)->remove($cart, $lineId);

        $this->loadCart();

        $this->dispatch('cartUpdated');
        $this->dispatch('notify', type: 'success', title: __('Cart updated'), message: __('The product has been removed from your cart!'));
    }

    public function render(): View
    {
        return view('livewire.shopping-cart');
    }
}
