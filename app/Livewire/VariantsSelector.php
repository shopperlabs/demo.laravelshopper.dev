<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class VariantsSelector extends Component
{
    public Product $product;

    public function render(): View
    {
        return view('livewire.components.variants-selector');
    }
}
