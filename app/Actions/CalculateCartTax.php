<?php

declare(strict_types=1);

namespace App\Actions;

use App\Adapters\CartItemTaxAdapter;
use App\CheckoutSession;
use Darryldecode\Cart\Facades\CartFacade;
use Shopper\Core\Models\TaxZone;
use Shopper\Core\Taxes\TaxCalculationContext;
use Shopper\Core\Taxes\TaxCalculator;

final class CalculateCartTax
{
    /** @var array{total: int, lines: array<int, array{item_id: int, tax_rate_id: ?int, amount: int}>, is_inclusive: bool}|null */
    private static ?array $cached = null;

    /**
     * @return array{total: int, lines: array<int, array{item_id: int, tax_rate_id: ?int, amount: int}>, is_inclusive: bool}
     */
    public function handle(): array
    {
        return self::$cached ??= $this->calculate();
    }

    /**
     * @return array{total: int, lines: array<int, array{item_id: int, tax_rate_id: ?int, amount: int}>, is_inclusive: bool}
     */
    private function calculate(): array
    {
        $zone = ZoneSessionManager::getSession();

        if (! $zone) {
            return ['total' => 0, 'lines' => [], 'is_inclusive' => false];
        }

        $provinceCode = $this->resolveProvinceCode($zone->countryCode);

        $context = new TaxCalculationContext(
            countryCode: $zone->countryCode,
            provinceCode: $provinceCode,
        );

        $calculator = resolve(TaxCalculator::class);
        $taxZone = $calculator->resolveZone($context);

        $cartItems = CartFacade::session(session()->getId())->getContent(); // @phpstan-ignore-line

        $adapters = [];
        $itemIds = [];

        foreach ($cartItems as $item) { // @phpstan-ignore-line
            $adapters[] = CartItemTaxAdapter::fromCartItem($item);
            $itemIds[] = $item->id; // @phpstan-ignore-line
        }

        $allTaxLines = $calculator->calculateMany($adapters, $context);

        $totalTax = 0;
        $lines = [];

        foreach ($allTaxLines as $index => $taxLines) {
            $itemTax = 0;
            $taxRateId = null;

            foreach ($taxLines as $line) {
                $itemTax += $line->amount;
                $taxRateId = $line->taxRateId;
            }

            $totalTax += $itemTax;
            $lines[] = [
                'item_id' => $itemIds[$index],
                'tax_rate_id' => $taxRateId,
                'amount' => $itemTax,
            ];
        }

        return ['total' => $totalTax, 'lines' => $lines, 'is_inclusive' => $taxZone?->is_tax_inclusive ?? false];
    }

    private function resolveProvinceCode(string $countryCode): ?string
    {
        $shippingAddress = session()->get(CheckoutSession::SHIPPING_ADDRESS);
        $state = data_get($shippingAddress, 'state');

        if (! $state) {
            return null;
        }

        $state = mb_strtoupper(mb_trim($state));
        $prefix = $countryCode.'-';

        // Handle both "CA" and "US-CA" formats
        $candidate = str_starts_with($state, $prefix) ? $state : $prefix.$state;

        return TaxZone::query()
            ->whereHas('country', fn ($q) => $q->where('cca2', $countryCode))
            ->whereNotNull('province_code')
            ->where('province_code', $candidate)
            ->value('province_code');
    }
}
