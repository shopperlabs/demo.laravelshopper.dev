<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Shopper\Enum\RenderHook;
use Shopper\Facades\Shopper;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Shopper::registerViteTheme('resources/css/shopper.css')
            ->renderHook(RenderHook::HeadEnd, fn (): string => Blade::render('@fluxAppearance'))
            ->renderHook(RenderHook::BodyEnd, fn (): string => Blade::render('@fluxScripts'));
    }
}
