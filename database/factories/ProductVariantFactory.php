<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ProductVariant;
use Shopper\Core\Database\Factories\ProductVariantFactory as ShopperProductVariantFactory;

final class ProductVariantFactory extends ShopperProductVariantFactory
{
    protected $model = ProductVariant::class;
}
