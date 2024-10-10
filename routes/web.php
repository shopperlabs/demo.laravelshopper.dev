<?php

declare(strict_types=1);

use App\Livewire\Checkout;
use App\Livewire\Pages;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Pages\Home::class)->name('home');
Route::get('/products/{slug}', Pages\SingleProduct::class)->name('single-product');

Route::middleware('auth')->group(function (): void {
    Route::view('dashboard', 'dashboard')->middleware(['verified'])->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::prefix('account')->as('account.')->group(function (): void {
        Volt::route('/', 'pages.customer.account')
            ->middleware(['verified'])
            ->name('show');

        Route::view('profile', 'profile')->name('profile');
        Route::get('/addresses', Pages\Customer\Addresses::class)->name('addresses');
        Route::get('/orders', Pages\Customer\Orders::class)->name('orders');
        Volt::route('/orders/{number}', 'pages.customer.orders.detail')->name('orders.detail');
    });
});

require __DIR__.'/auth.php';

