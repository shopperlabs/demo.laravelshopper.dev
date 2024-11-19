<?php

namespace App\Livewire\Pages\Category;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Contracts\View\View;

final class CategoryProducts extends Component
{
    public $categorySlug;
    public $category;
    public $products = [];

    public function mount($slug)
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