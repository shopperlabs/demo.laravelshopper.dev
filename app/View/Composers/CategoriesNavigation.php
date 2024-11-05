<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

final class CategoriesNavigation
{
    public function compose(View $view): void
    {
        $view->with(
            'categories',
            once(fn () => Category::isRoot()->scopes(['enabled'])->limit(6)->get()
            ));
    }
}
