<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\On;

final class ShoppingCart extends SlideOverComponent
{
    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    #[On('cartUpdated')]
    public function render(): View
    {
        return view('livewire.shopping-cart');
    }
}
