<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CountryFactory;
use Shopper\Core\Models\Country as Model;

final class Country extends Model
{
    protected static function newFactory(): CountryFactory
    {
        return CountryFactory::new();
    }
}
