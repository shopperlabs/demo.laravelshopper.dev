<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Home extends Component
{
    public function render(): View
    {
        return view('livewire.pages.home', [
            'products' => Product::with(['brand', 'media'])
                ->publish()
                ->get(),
        ]);
    }
}
