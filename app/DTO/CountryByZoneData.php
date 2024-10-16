<?php

declare(strict_types=1);

namespace App\DTO;

final class CountryByZoneData
{
    public function __construct(
        public int $zoneId,
        public string $zoneCode,
        public string $zoneName,
        public int $countryId,
        public string $countryName,
        public string $countryCode,
        public string $countryFlag,
        public string $currencyCode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            zoneId: data_get($data, 'zone_id'),
            zoneCode: data_get($data, 'zone_code'),
            zoneName: data_get($data, 'zone_name'),
            countryId: data_get($data, 'country_id'),
            countryName: data_get($data, 'country_name'),
            countryCode: data_get($data, 'country_code'),
            countryFlag: data_get($data, 'country_flag'),
            currencyCode: data_get($data, 'currency_code'),
        );
    }
}
