<?php

declare(strict_types=1);

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Shopper\Core\Models\Product as ShopperProduct;

final class Product extends ShopperProduct implements Viewable
{
    use InteractsWithViews;
}
