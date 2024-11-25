<?php

declare(strict_types=1);

namespace App\Livewire\Components\Product;

use App\Models\Product;
use App\Traits\HasProductRatings;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.templates.account')]
class Reviews extends Component
{
    use HasProductRatings;

    public Product $product;

    public function mount(): void
    {
        $this->update();
    }

    #[On('reviewCreated')]
    public function update(): void
    {
        $this->loadProductRatings($this->product);
    }

    public function render(): View
    {
        return view('livewire.components.product.reviews');
    }
}
