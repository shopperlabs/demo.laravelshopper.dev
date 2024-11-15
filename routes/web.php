<?php

declare(strict_types=1);

use App\Http\Controllers\NotchPayCallBackController;
use App\Livewire\Pages;
use App\Livewire\Pages\Checkout;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', Pages\Home::class)->name('home');
Route::get('/products/{slug}', Pages\SingleProduct::class)->name('single-product');

Route::middleware('auth')->group(function (): void {
    Route::get('/checkout', Checkout::class)->name('checkout');
    Volt::route('/dashboard', 'pages.customer.account')->name('dashboard');

    Route::prefix('dashboard')->as('dashboard.')->group(function (): void {
        Volt::route('profile', 'pages.customer.profile')->name('profile');
        Route::get('addresses', Pages\Customer\Addresses::class)->name('addresses');
        Route::get('orders', Pages\Customer\Orders::class)->name('orders');
        Volt::route('orders/{number}', 'pages.customer.orders.detail')->name('orders.detail');
    });

    Volt::route('/order/confirmed/{number}', 'pages.order.confirmed')
        ->name('order-confirmed');
});

Route::get('callback-payment', NotchPayCallBackController::class)->name('notchpay-callback');

require __DIR__ . '/auth.php';
