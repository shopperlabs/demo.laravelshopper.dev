<?php

declare(strict_types=1);

namespace App\Livewire\Modals;

use App\Models\Product;
use App\Traits\HasProductRatings;
use Illuminate\Contracts\View\View;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;

class ReviewsList extends SlideOverComponent
{
    use HasProductRatings;

    public Product $product;

    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    public function mount(): void
    {
        $this->loadProductRatings($this->product);
    }

    public function render(): View
    {
        return view('livewire.modals.reviews-list');
    }
}
