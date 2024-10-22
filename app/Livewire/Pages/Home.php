<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopper\Core\Models\Collection;

final class Home extends Component
{
    public function render(): View
    {
        return view('livewire.pages.home', [
            'products' => Product::with(['brand', 'media'])
                ->publish()
                ->get(),
            'collections' => Collection::with('media')
                ->select('id', 'name', 'slug', 'description')
                ->limit(3)
                ->get(),
        ]);
    }
}
