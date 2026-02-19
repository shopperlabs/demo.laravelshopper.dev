<?php

declare(strict_types=1);

namespace App\Livewire\SlideOvers;

use App\DTO\ProductReviewsData;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\Computed;

class ReviewsList extends SlideOverComponent
{
    public Product $product;

    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    #[Computed]
    public function productReviews(): ProductReviewsData
    {
        $reviews = $this->product->ratings()
            ->with('author')
            ->where('approved', true)
            ->latest()
            ->get();

        return new ProductReviewsData(
            reviews: $reviews,
            averageRating: $reviews->isNotEmpty()
                ? round($reviews->avg('rating'), 1)
                : 0,
            totalCount: $reviews->count(),
        );
    }

    public function render(): View
    {
        return view('livewire.slideovers.reviews-list');
    }
}
