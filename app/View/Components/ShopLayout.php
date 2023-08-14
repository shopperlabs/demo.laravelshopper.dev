<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class ShopLayout extends Component
{
    public function render(): View
    {
        return view('layouts.shop');
    }
}
