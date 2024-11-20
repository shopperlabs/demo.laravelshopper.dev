<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SingleProduct extends Component
{
    public ?Product $product = null;

    public function mount(string $slug): void
    {
        $this->product = Product::with(['brand', 'media', 'attributes', 'relatedProducts', 'variants.media'])
            ->scopes('publish')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function addToCart(Product $product): void
    {
        $product->loadMissing('media');
        // @phpstan-ignore-next-line
        CartFacade::session(session()->getId())->add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price_amount,
            'quantity' => 1,
            'attributes' => $product->attributes,
            'associatedModel' => $product,
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
        return view('livewire.pages.single-product')
            ->title($this->product->name);
    }
}
