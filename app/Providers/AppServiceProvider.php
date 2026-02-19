<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Shopper\Enum\RenderHook;
use Shopper\Facades\Shopper;
use Shopper\Sidebar\SidebarBuilder;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        Shopper::registerViteTheme('resources/css/shopper.css')
            ->renderHook(RenderHook::HeadEnd, fn (): string => Blade::render('@fluxAppearance'))
            ->renderHook(RenderHook::BodyEnd, fn (): string => Blade::render('@fluxScripts'));

        Event::listen(SidebarBuilder::class, \App\Sidebar\BlogSidebar::class);

        View::composer('components.layouts.footer', function ($view): void {
            $view->with(
                'footerCategories',
                cache()->remember(
                    'footer_categories',
                    now()->addDay(),
                    fn () => Category::query()
                        ->whereNull('parent_id')
                        ->where('is_enabled', true)
                        ->has('products')
                        ->withCount(['products' => fn ($q) => $q->whereNull(shopper_table('products').'.deleted_at')])
                        ->orderByDesc('products_count')
                        ->limit(3)
                        ->get()
                )
            );
        });
    }
}
