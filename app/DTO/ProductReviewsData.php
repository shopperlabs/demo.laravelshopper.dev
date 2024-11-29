<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Support\Collection;

class ProductReviewsData
{
    public function __construct(
        public Collection $reviews,
        public float $averageRating = 0,
    ) {}
}
