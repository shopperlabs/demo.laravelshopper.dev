<?php

namespace App\Models;

use Database\Factories\AddressFactory;
use Shopper\Core\Models\Address as Model;

// @ToDo: After update shopper delete this file
final class Address extends Model
{
    protected static function newFactory(): \Shopper\Core\Database\Factories\AddressFactory
    {
        return AddressFactory::new();
    }
}
