<?php

declare(strict_types=1);

use App\Livewire\Shopper\Blog;
use Illuminate\Support\Facades\Route;

Route::as('blog.')->prefix('blog')->group(function (): void {
    Route::get('posts', Blog\PostIndex::class)->name('posts.index');
    Route::get('posts/create', Blog\PostForm::class)->name('posts.create');
    Route::get('posts/{post}/edit', Blog\PostForm::class)->name('posts.edit');
    Route::get('categories', Blog\CategoryIndex::class)->name('categories.index');
});
