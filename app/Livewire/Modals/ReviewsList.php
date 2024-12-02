<?php

declare(strict_types=1);

namespace App\Livewire\Modals;

use App\DTO\ProductReviewsData;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class ReviewsList extends SlideOverComponent
{
    public Product $product;

    #[Computed]
    #[On('reviewCreated')]
    public function productReviews(): ProductReviewsData
    {
        return new ProductReviewsData(
            reviews: $this->product->getApprovedRatings($this->product->id),
            averageRating: floatval($this->product->averageRating(1)->first())
        );
    }

    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    public function render(): View
    {
        return view('livewire.modals.reviews-list');
    }
}
