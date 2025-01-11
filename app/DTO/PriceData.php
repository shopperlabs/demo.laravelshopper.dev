<?php

declare(strict_types=1);

namespace App\DTO;

use Shopper\Core\Helpers\Price;

final class PriceData
{
    public function __construct(
        public Price $amount,
        public ?Price $compare,
        public ?float $percentage,
    ) {}
}
