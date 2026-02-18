<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Shopper\Core\Database\Factories\ProductFactory as ShopperProductFactory;

final class ProductFactory extends ShopperProductFactory
{
    protected $model = Product::class;
}
