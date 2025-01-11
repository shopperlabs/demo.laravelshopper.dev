<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Product;
use Illuminate\Support\Collection;

trait HasProductRatings
{
    public float $averageRating = 0;

    public float $reviewsCount = 0;

    public ?Collection $reviews = null;

    public function loadProductRatings(Product $product): void
    {
        // @phpstan-ignore-next-line
        $this->averageRating = floatval($product->averageRating(1)->first()) ?? $this->averageRating;
        $this->reviewsCount = $product->countRating();
        $this->reviews = $product->getApprovedRatings($product->id);
    }
}
