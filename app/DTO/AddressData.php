<?php

declare(strict_types=1);

namespace App\DTO;

final class AddressData
{
    public function __construct(
        public ?string $firstName,
        public ?string $lastName,
        public ?string $company,
        public string $streetAddress,
        public ?string $streetAddressPlus,
        public string $postalCode,
        public string $city,
        public ?string $phoneNumber,
        public int $countryId,
    ) {}

    /**
     * @param  array<string>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            firstName: data_get($data, 'first_name'),
            lastName: data_get($data, 'last_name'),
            company: data_get($data, 'company'),
            streetAddress: data_get($data, 'street_address'),
            streetAddressPlus: data_get($data, 'street_address_plus'),
            postalCode: data_get($data, 'postal_code'),
            city: data_get($data, 'city'),
            phoneNumber: data_get($data, 'phone_number'),
            countryId: (int) data_get($data, 'country_id'),
        );
    }
}
