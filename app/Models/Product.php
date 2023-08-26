<?php

declare(strict_types=1);

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Shopper\Core\Models\Product as ShopperProduct;

final class Product extends ShopperProduct implements Viewable
{
    use InteractsWithViews;

    public function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->old_price_amount > 0
                ? round((($this->old_price_amount - $this->price_amount) / $this->old_price_amount) * 100)
                : 0
        );
    }
}
