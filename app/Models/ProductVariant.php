<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasProductPricing;
use Database\Factories\ProductVariantFactory;
use Shopper\Core\Models\ProductVariant as Model;

final class ProductVariant extends Model
{
    use HasProductPricing;

    protected static function newFactory(): ProductVariantFactory
    {
        return ProductVariantFactory::new();
    }
}
