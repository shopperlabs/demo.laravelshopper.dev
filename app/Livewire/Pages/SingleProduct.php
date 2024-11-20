<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Livewire\Component;

final class SingleProduct extends Component
{
    public ?Product $product = null;

    public ?Product $currentVariant = null;

    public function mount(string $slug, Request $request): void
    {
        $search = $request->query('variant');
        if ($search) {
            $this->currentVariant = Product::with('media')
                ->where('slug', $search)
                ->firstOrFail();
        }

        $this->product = Product::with(['brand', 'media', 'attributes', 'relatedProducts', 'variants.media'])
            ->scopes('publish')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.pages.single-product')
            ->title($this->product->name);
    }
}
