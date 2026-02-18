<?php

declare(strict_types=1);

namespace App\Traits;

use App\DTO\PriceData;
use Shopper\Core\Helpers\Price;

trait HasProductPricing
{
    public function getFormattedPrice(): ?PriceData
    {
        $currencyCode = current_currency();

        $this->loadMissing('prices.currency');

        $price = $this->prices
            ->reject(fn ($price): bool => $price->currency->code !== $currencyCode)
            ->first();

        return $price
            ? new PriceData(
                amount: Price::from($price->amount, $currencyCode),
                compare: $price->compare_amount ? Price::from($price->compare_amount, $currencyCode) : null,
                percentage: $price->compare_amount > 0
                    ? round((($price->compare_amount - $price->amount) / $price->compare_amount) * 100)
                    : null
            )
            : null;
    }
}
