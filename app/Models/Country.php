<?php

namespace App\Models;

use Database\Factories\CountryFactory;
use Shopper\Core\Models\Country as Model;

// @ToDo: After update shopper delete this file
final class Country extends Model
{
    protected static function newFactory(): CountryFactory
    {
        return CountryFactory::new();
    }
}
