<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Product;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.templates.account')]
class ProductReviews extends Component
{
    public Product $product;

    #[On('review-updated')]
    public function render(): View
    {
        $averageRating = $this->product->averageRating(1, true)->first();

        $reviewCounts = $this->product->ratings()
            ->selectRaw('rating, COUNT(*) as count')
            ->where('approved', '1')
            ->groupBy('rating')
            ->orderByDesc('rating')
            ->get();

        $totalReviews = $this->product->countRating();
        return view('livewire.pages.product.product-reviews', [
            'averageRating' => $averageRating,
            'reviewCounts' => $reviewCounts,
            'totalReviews' => $totalReviews,
        ]);
    }
}
