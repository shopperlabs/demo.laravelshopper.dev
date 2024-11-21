<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
}
