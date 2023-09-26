<?php

declare(strict_types=1);

namespace App\Http\Livewire\Collections;

use App\Models\Collection;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class GridCards extends Component
{
    public int $limit = 2;

    public function render(): View
    {
        return view('livewire.collections.grid-cards', [
            'collections' => Collection::with('media')
                ->select('id', 'name', 'slug', 'description')
                ->limit($this->limit)
                ->get(),
        ]);
    }
}
