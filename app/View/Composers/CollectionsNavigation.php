<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Collection;
use Illuminate\View\View;

final class CollectionsNavigation
{
    public function compose(View $view): void
    {
        $view->with(
            'collections',
            once(fn () => Collection::whereHas('products')
                ->orderBy('created_at')
                ->get()
            )
        );
    }
}
