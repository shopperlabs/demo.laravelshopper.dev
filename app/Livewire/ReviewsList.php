<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;

class ReviewsList extends SlideOverComponent
{
    public Collection $reviewsList;

    public Product $product;

    public float $averageRating = 0;

    public float $reviewsCount = 0;

    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    public function mount(): void
    {
        // @phpstan-ignore-next-line
        $this->averageRating = floatval($this->product->averageRating()[0]) ?? $this->averageRating;
        $this->reviewsCount = $this->product->countRating();
        $this->reviewsList = $this->product->getApprovedRatings($this->product->id);
    }

    public function render(): View
    {
        return view('livewire.reviews-list');
    }
}
