<?php

declare(strict_types=1);

namespace App\View\Components\Menu;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class ParentCategory extends Component
{
    public function render(): View
    {
        return view('components.menu.parent-category', [
            'categories' => Category::isRoot()->get(),
        ]);
    }
}
