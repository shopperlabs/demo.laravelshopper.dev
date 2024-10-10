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
    Route::view('profile', 'profile')->name('profile');
    Route::get('/checkout', Checkout::class)->name('checkout');

    Volt::route('/dashboard', 'pages.customer.account')->middleware(['verified'])->name('dashboard');

    Route::prefix('dashboard')->as('dashboard.')->group(function (): void {
        Route::view('profile', 'profile')->name('profile');
        Volt::route('/orders/{number}', 'pages.customer.orders.detail')->name('orders.detail');
    });
});

require __DIR__.'/auth.php';

