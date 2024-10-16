<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\AddressFactory;
use Shopper\Core\Enum\AddressType;
use Shopper\Core\Models\Address as Model;

// @ToDo: After update shopper delete this file
/**
 * @property AddressType $type
 */
final class Address extends Model
{
    protected static function newFactory(): \Shopper\Core\Database\Factories\AddressFactory
    {
        return AddressFactory::new();
    }
}
