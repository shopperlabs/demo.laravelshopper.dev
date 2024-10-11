<?php

declare(strict_types=1);

namespace App\Livewire\Modals;

use App\Actions\CountriesWithZone;
use App\Actions\ZoneSessionManager;
use App\DTO\CountryByZoneData;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\Computed;

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
            ZoneSessionManager::setSession($selectedZone);
            session()->forget('checkout');

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
        return view('livewire.modals.zone-selector');
    }
}
