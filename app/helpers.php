<?php

declare(strict_types=1);

use App\Actions\ZoneSessionManager;
use App\Models\Channel;
use Shopper\Cart\CartSessionManager;
use Shopper\Cart\Models\Cart;
use Shopper\Core\Models\TaxZone;

if (! function_exists('cartSession')) {
    function cartSession(): Cart
    {
        $session = resolve(CartSessionManager::class);
        $cart = $session->current();

        if (! $cart) {
            $zone = ZoneSessionManager::getSession();
            $defaultChannel = Channel::query()->scopes('default')->first();

            $cart = $session->create([
                'currency_code' => current_currency(),
                'channel_id' => $defaultChannel?->id,
                'zone_id' => $zone?->zoneId,
                'customer_id' => auth()->id(),
            ]);
        }

        return $cart;
    }
}

if (! function_exists('format_cents')) {
    /**
     * Convert an amount stored in cents to a formatted currency string.
     * Handles zero-decimal currencies (XAF, JPY, etc.) automatically.
     */
    function format_cents(int $amount, ?string $currency = null): string
    {
        $currency ??= current_currency();

        return shopper_money_format($amount, $currency);
    }
}

if (! function_exists('current_currency')) {
    function current_currency(): string
    {
        return ZoneSessionManager::checkSession()
            ? ZoneSessionManager::getSession()->currencyCode
            : shopper_currency();
    }
}

if (! function_exists('current_tax_label')) {
    function current_tax_label(): string
    {
        static $label = null;

        if ($label !== null) {
            return $label;
        }

        $zone = ZoneSessionManager::getSession();

        if (! $zone instanceof App\DTO\CountryByZoneData) {
            return $label = '';
        }

        $taxZone = TaxZone::query()
            ->whereHas('country', fn ($q) => $q->where('cca2', $zone->countryCode))
            ->whereNull('province_code')
            ->first();

        return $label = $taxZone?->is_tax_inclusive ? __('TTC') : __('HT');
    }
}
