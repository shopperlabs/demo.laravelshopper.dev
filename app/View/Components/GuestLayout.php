<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class GuestLayout extends Component
{
    public function render(): View
    {
        return view('layouts.guest');
    }
}
