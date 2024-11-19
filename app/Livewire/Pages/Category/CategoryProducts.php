<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

final class CategoryProducts extends Component
{
    public string $categorySlug;

    public Category $category;

    public Collection $products;

    public function mount(string $slug): void
    {
        $this->categorySlug = $slug;
        $this->category = Category::where('slug', $this->categorySlug)->firstOrFail();
        $this->products = $this->category->products;
    }

    public function render(): View
    {
        return view('livewire.category.category-products');
    }
}
