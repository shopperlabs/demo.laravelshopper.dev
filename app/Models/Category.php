<?php

declare(strict_types=1);

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Shopper\Core\Models\Category as ShopperCategory;

final class Category extends ShopperCategory implements Viewable
{
    use InteractsWithViews;
}
