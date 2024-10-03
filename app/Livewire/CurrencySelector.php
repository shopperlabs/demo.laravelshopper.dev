<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Laravelcm\AbstractIpGeolocation\DataObject\GeolocationData;
use Livewire\Component;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\Currency;

final class CurrencySelector extends Component
{
    public ?string $currency_code = null;

    public ?string $country_flag = null;

    public array $availableCurrencies = [];

    public function mount(): void
    {
        if (! session()->has('default_currency_code')) {
            session()->put('default_currency_code', shopper_currency());
        }

        $this->availableCurrencies = Currency::query()
            ->whereIn('id', shopper_setting('currencies', false))
            ->pluck('code', 'id')
            ->toArray();

        /** @var GeolocationData $userGeolocation */
        $userGeolocation = session()->get('abstract-ip-geolocation');

        if ($userGeolocation && $userGeolocation->currency) {
            $userCurrencyCode = $userGeolocation->currency->code;

            $availableCurrencies = array_values($this->availableCurrencies);

            if (in_array($userCurrencyCode, $availableCurrencies)) {
                if (! session()->has('session_currency_code')) {
                    session()->put('session_currency_code', $userCurrencyCode);
                }

                $this->currency_code = $userCurrencyCode;
            } else {
                $this->currency_code = shopper_currency();
            }

            $this->country_flag = Country::query()
                ->select('cca2')
                ->where('cca2', $userGeolocation->countryCode)
                ->first()
                ->svg_flag;
        } else {
            $this->currency_code = session()->get('default_currency_code') ?? shopper_currency();
            $this->country_flag = Country::query()->select('cca2')
                ->find((int) shopper_setting('country_id'))
                ->svg_flag;
        }
    }

    public function updateCurrency(string $currency): void
    {
        session()->put('session_currency_code', $currency);
    }

    public function placeholder(): string
    {
        return <<<Blade
            <div class="flex items-center gap-2">
                <x-shopper::skeleton class="w-6 h-5 rounded-none" />
                <x-shopper::skeleton class="w-10 h-3 rounded" />
            </div>
        Blade;
    }

    public function render(): View
    {
        return view('livewire.currency-selector');
    }
}
