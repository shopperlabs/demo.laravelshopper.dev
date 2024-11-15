<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Product;
use Darryldecode\Cart\CartCollection;
use Darryldecode\Cart\Facades\CartFacade;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\On;

final class ShoppingCart extends SlideOverComponent
{
    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    public float $subtotal = 0;

    public CartCollection $items;

    public ?string $sessionKey = null;

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
        /** @var Product $product */
        $product = Product::query()->find($id);
        CartFacade::session($this->sessionKey)->remove($id); // @phpstan-ignore-line

        Notification::make()
            ->title(__('Cart updated'))
            ->body(__('The product ":name" has been removed from your cart !', ['name' => $product->name]))
            ->success()
            ->send();

        $this->dispatch('cartUpdated');
        $this->dispatch('closePanel');
    }

    public function render(): View
    {
        return view('livewire.shopping-cart');
    }
}
