<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/account', fn () => view('pages.account.index'))
    ->middleware(['auth', 'verified'])
    ->name('account');

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/legal/{slug}', LegalController::class)
    ->name('legal')
    ->where('slug', '[a-z0-9-]+');

require __DIR__.'/auth.php';
