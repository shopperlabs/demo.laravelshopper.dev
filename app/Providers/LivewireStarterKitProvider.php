<?php

declare(strict_types=1);

namespace App\Providers;

use App\View\Composers\CategoriesNavigation;
use App\View\Composers\CollectionsNavigation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class LivewireStarterKitProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsComposer();
    }

    public function boot(): void
    {
        //
    }

    private function loadViewsComposer(): void
    {
        View::composer('components.layouts.header', CategoriesNavigation::class);
        View::composer('components.layouts.header', CollectionsNavigation::class);
    }
}
