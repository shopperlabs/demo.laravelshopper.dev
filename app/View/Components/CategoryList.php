<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

final class CategoryList extends Component
{
    public function render(): View
    {
        return view('components.category-list', [
            'categories' => Category::withRecursiveQueryConstraint(
                constraint: function (Builder $query): void {
                    $query->where('categories.is_enabled', true);
                },
                query: fn () => Category::with('media')->tree()->get()
            ),
        ]);
    }
}
