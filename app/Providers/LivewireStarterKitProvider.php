<?php

declare(strict_types=1);

namespace App\Providers;

use App\View\Composers\CategoriesNavigation;
use Illuminate\Database\Eloquent\Model;
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
        Model::preventLazyLoading();
    }

    private function loadViewsComposer(): void
    {
        View::composer('components.layouts.header', CategoriesNavigation::class);
    }
}
