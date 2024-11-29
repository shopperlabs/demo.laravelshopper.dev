<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Livewire\Component;

final class VariantsSelector extends Component
{
    public Product $product;

    public ?string $search = null;

    public ?Product $currentVariant = null;

    public function mount(Request $request): void
    {
        $this->search = $request->query('variant');
    }

    public function addToCart(): void
    {
        $this->product->loadMissing('media');
        // @phpstan-ignore-next-line
        CartFacade::session(session()->getId())->add([
            'id' => (! $this->currentVariant) ? $this->product->id : $this->currentVariant->id,
            'name' => (! $this->currentVariant) ? $this->product->name : $this->product->name . ' / ' . $this->currentVariant->name,
            'price' => (! $this->currentVariant) ? $this->product->price_amount : $this->currentVariant->price_amount,
            'quantity' => 1,
            'attributes' => (! $this->currentVariant) ? $this->product->attributes : [],
            'associatedModel' => (! $this->currentVariant) ? $this->product : $this->currentVariant,
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
