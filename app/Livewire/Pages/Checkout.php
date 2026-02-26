<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\CheckoutSession;
use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Shopper\Cart\CartManager;
use Shopper\Cart\CartSessionManager;

#[Layout('components.layouts.templates.light')]
final class Checkout extends Component
{
    public function mount(): void
    {
        $cart = app(CartSessionManager::class)->current();

        if (! $cart || $cart->lines->isEmpty()) {
            if (session()->exists(CheckoutSession::KEY)) {
                session()->forget(CheckoutSession::KEY);
            }

            $this->redirect(route('home'), true);
        }
    }

    public function render(): View
    {
        $cart = cartSession();
        $cart->load('lines.purchasable');
        $cart->lines->loadMorph('purchasable', [
            ProductVariant::class => ['product'],
        ]);

        $context = app(CartManager::class)->calculate($cart);

        return view('livewire.pages.checkout', [
            'items' => $cart->lines,
            'subtotal' => $context->subtotal,
        ])
            ->title(__('Proceed to checkout'));
    }
}
