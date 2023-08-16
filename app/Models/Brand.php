<?php

declare(strict_types=1);

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Shopper\Core\Models\Brand as ShopperBrand;

final class Brand extends ShopperBrand implements Viewable
{
    use InteractsWithViews;
}
