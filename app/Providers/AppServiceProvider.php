<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Category;
use App\Sidebar\BlogSidebar;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Shopper\Cart\CartSessionManager;
use Shopper\Facades\Shopper;
use Shopper\Sidebar\SidebarBuilder;
use Shopper\View\LayoutRenderHook;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        URL::forceScheme('https');

        Model::preventLazyLoading(! app()->isProduction());

        Shopper::renderHook(LayoutRenderHook::HEAD_END, fn (): string => Blade::render('@fluxAppearance'))
            ->renderHook(LayoutRenderHook::BODY_END, fn (): string => Blade::render('@fluxScripts'));

        Event::listen(SidebarBuilder::class, BlogSidebar::class);

        Event::listen(Login::class, function (Login $event): void {
            resolve(CartSessionManager::class)->associate($event->user);
        });

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
