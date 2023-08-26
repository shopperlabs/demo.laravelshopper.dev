<?php

declare(strict_types=1);

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BestDeals extends Component
{
    public function render(): View
    {
        return view('livewire.products.best-deals', [
            'products' => Product::with(['media', 'brand'])
                ->scopes('publish')
                ->select(
                    'id',
                    'name',
                    'slug',
                    'price_amount',
                    'old_price_amount',
                    'brand_id'
                )
                ->where('old_price_amount', '>', 0)
                ->take(4)
                ->get(),
        ]);
    }
}
