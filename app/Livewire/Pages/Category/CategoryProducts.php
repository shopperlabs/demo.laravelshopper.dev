<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class CategoryProducts extends Component
{
    public Category $category;

    public function mount(string $slug): void
    {
        $this->category = Category::with('products')->where('slug', $slug)->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.category.category-products', ['products' => $this->category->products]);
    }
}
