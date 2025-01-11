<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasProductPricing;
use Shopper\Core\Models\Product as Model;

final class Product extends Model
{
    use HasProductPricing;

    public function isPublished(): bool
    {
        return $this->is_visible && $this->published_at && $this->published_at <= now();
    }
}
