<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Product;
use Illuminate\Support\Collection;

trait HasProductRatings
{
    public ?float $averageRating = 0;

    public ?float $reviewsCount = 0;

    public ?Collection $reviews = null;

    public ?Collection $reviewsList = null;

    public function loadProductRatings(Product $product, int $limit = 3): void
    {
        // @phpstan-ignore-next-line
        $this->averageRating = floatval($product->averageRating()[0]) ?? $this->averageRating;
        $this->reviewsCount = $product->countRating();
        $this->reviews = $product->getRecentRatings($product->id, $limit);
        $this->reviewsList = $product->getApprovedRatings($product->id);
    }
}
