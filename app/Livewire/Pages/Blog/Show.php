<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Blog;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Show extends Component
{
    public BlogPost $post;

    public function mount(): void
    {
        abort_unless($this->post->is_published, 404);

        $this->post->load(['category', 'author', 'media']);
    }

    public function render(): View
    {
        return view('livewire.pages.blog.show')
            ->title($this->post->title);
    }
}
