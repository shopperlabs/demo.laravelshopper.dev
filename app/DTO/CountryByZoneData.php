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

    public static function fromArray(array $data): self
    {
        return new self(
            zoneId: $data['zone_id'],
            zoneCode: $data['zone_code'],
            zoneName: $data['zone_name'],
            countryId: $data['country_id'],
            countryName: $data['country_name'],
            countryCode: $data['country_code'],
            countryFlag: $data['country_flag'],
            currencyCode: $data['currency_code'],
        );
    }
}
