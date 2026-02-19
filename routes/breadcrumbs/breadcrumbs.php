<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

Breadcrumbs::for('home', function (Generator $trail): void {
    $trail->push(__('Home'), route('home'));
});

Breadcrumbs::for('store', function (Generator $trail): void {
    $trail->parent('home');
    $trail->push(__('Store'), route('store'));
});

Breadcrumbs::for('category', function (Generator $trail, $category): void {
    $trail->parent('home');

    $ancestors = $category->ancestorsAndSelf()
        ->orderBy('depth')
        ->get();

    foreach ($ancestors as $ancestor) {
        $trail->push($ancestor->name, route('category.products', $ancestor));
    }
});

Breadcrumbs::for('collections', function (Generator $trail): void {
    $trail->parent('home');
    $trail->push(__('Collections'), route('collections'));
});

Breadcrumbs::for('collection', function (Generator $trail, $collection): void {
    $trail->parent('collections');
    $trail->push($collection->name, route('collection.products', $collection));
});

Breadcrumbs::for('blog', function (Generator $trail): void {
    $trail->parent('home');
    $trail->push(__('Blog'), route('blog.index'));
});

Breadcrumbs::for('blog.show', function (Generator $trail, $post): void {
    $trail->parent('blog');
    $trail->push($post->title);
});

Breadcrumbs::for('product', function (Generator $trail, $product): void {
    $category = $product->categories()->whereNotNull('parent_id')->first()
        ?? $product->categories()->first();

    if ($category) {
        $trail->parent('category', $category);
    } else {
        $trail->parent('store');
    }

    $trail->push($product->name);
});
