<?php

declare(strict_types=1);

namespace App\Providers;

use App\Sidebar\QuestionsSidebar;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Shopper\Enum\RenderHook;
use Shopper\Facades\Shopper;
use Shopper\Sidebar\SidebarBuilder;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app['events']->listen(SidebarBuilder::class, QuestionsSidebar::class);
    }

    public function boot(): void
    {
        Shopper::registerViteTheme('resources/css/shopper.css')
            ->renderHook(RenderHook::HeadEnd, fn (): string => Blade::render('@fluxAppearance'))
            ->renderHook(RenderHook::BodyEnd, fn (): string => Blade::render('@fluxScripts'));
    }
}
