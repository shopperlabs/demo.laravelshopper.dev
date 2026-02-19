<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Blog;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.pages.blog.index', [
            'posts' => BlogPost::query()
                ->published()
                ->with(['category', 'author', 'media'])
                ->latest('published_at')
                ->paginate(9),
        ])->title(__('Blog'));
    }
}
