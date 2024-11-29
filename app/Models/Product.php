<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Shopper\Core\Models\Product as Model;

final class Product extends Model
{
    /**
     * Scope a query to only include product parent.
     */
    public function scopeParent(Builder $query): void
    {
        $query->whereNull('parent_id');
    }

    public function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->old_price_amount > 0
                ? round((($this->old_price_amount - $this->price_amount) / $this->old_price_amount) * 100)
                : 0
        );
    }
}
