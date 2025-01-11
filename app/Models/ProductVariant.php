<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasProductPricing;
use Shopper\Core\Models\ProductVariant as Model;

final class ProductVariant extends Model
{
    use HasProductPricing;
}
