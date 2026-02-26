<?php

declare(strict_types=1);

namespace App\Livewire\SlideOvers;

use App\Actions\CountriesWithZone;
use App\Actions\ZoneSessionManager;
use App\CheckoutSession;
use App\DTO\CountryByZoneData;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\Computed;
use Shopper\Cart\CartSessionManager;

/**
 * @property Collection $countries
 */
final class ZoneSelector extends SlideOverComponent
{
    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    #[Computed]
    public function countries(): Collection
    {
        return (new CountriesWithZone)->handle();
    }

    public function selectZone(int $countryId): void
    {
        /** @var CountryByZoneData $selectedZone */
        $selectedZone = $this->countries->firstWhere('countryId', $countryId);

        if ($selectedZone->countryId !== ZoneSessionManager::getSession()?->countryId) {
            $oldCurrency = current_currency();

            ZoneSessionManager::setSession($selectedZone);

            session()->forget(CheckoutSession::KEY);

            $cart = app(CartSessionManager::class)->current();

            if ($cart) {
                $cart->update([
                    'zone_id' => $selectedZone->zoneId,
                    'currency_code' => $selectedZone->currencyCode,
                ]);
            }

            Cache::forget("home_featured_products_{$oldCurrency}");
            Cache::forget("home_featured_products_{$selectedZone->currencyCode}");

            $this->dispatch('zoneChanged');
        }

        $this->redirectIntended();
    }

    public function placeholder(): string
    {
        return <<<'Blade'
            <div class="flex items-center gap-2">
                <x-shopper::skeleton class="w-6 h-5 rounded-none" />
                <x-shopper::skeleton class="w-10 h-3 rounded" />
            </div>
        Blade;
    }

    public function render(): View
    {
        return view('livewire.slideovers.zone-selector');
    }
}
