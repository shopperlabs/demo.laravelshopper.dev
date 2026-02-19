<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasProductPricing;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Shopper\Core\Models\Product as Model;

final class Product extends Model
{
    use HasProductPricing;

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function withCurrentPrices(Builder $query): Builder
    {
        return $query->with([
            'prices' => fn ($q) => $q->whereRelation('currency', 'code', current_currency()),
            'prices.currency',
        ]);
    }
}
