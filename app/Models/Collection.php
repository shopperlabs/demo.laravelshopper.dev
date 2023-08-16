<?php

declare(strict_types=1);

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Shopper\Core\Models\Collection as ShopperCollection;

final class Collection extends ShopperCollection implements Viewable
{
    use InteractsWithViews;
}
