<?php

declare(strict_types=1);

namespace App\Traits;

use Shopper\Core\Enum\AddressType;

trait WithAddressAttributes
{
    public ?string $firstName = null;

    public ?string $lastName = null;

    public string $streetAddress = '';

    public ?string $streetAddressPlus = '';

    public AddressType $type ;

    public ?int $countryId = null;

    public ?string $postalCode = null;

    public ?string $city = null;

    public ?string $phoneNumber = '';

    public const REQUIRE_STRING = 'required|string';
    /**
     * @var array|string[]
     */
    protected array $rules = [
        'firstName' => self::REQUIRE_STRING,
        'lastName' => self::REQUIRE_STRING,
        'streetAddress' => self::REQUIRE_STRING,
        'streetAddressPlus' => 'string',
        'countryId' => 'int',
        'postalCode' => self::REQUIRE_STRING,
        'city' => self::REQUIRE_STRING,
        'phoneNumber' => 'string',
        'type' => 'required',
    ];


    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'firstName.required' => __('First name is required'),
            'lastName.required' => __('Last name is required'),
            'countryId.required' => __('Country is required'),
            'postalCode.required' => __('Postal code is required'),
            'streetAddress.required' => __('Street adddress is required'),
            'countryId.int' => __('Country is required'),
        ];
    }
}
