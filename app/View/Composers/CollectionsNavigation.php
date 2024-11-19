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
            once(fn () => Collection::withCount('products')
                ->having('products_count', '>', 0)
                ->orderBy('created_at')
                ->get()
            )
        );
    }
}
