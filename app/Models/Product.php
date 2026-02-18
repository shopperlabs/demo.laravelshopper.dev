<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasProductPricing;
use Database\Factories\ProductFactory;
use Shopper\Core\Models\Product as Model;

final class Product extends Model
{
    use HasProductPricing;

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
