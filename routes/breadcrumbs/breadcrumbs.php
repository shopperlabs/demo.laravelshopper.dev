<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

Breadcrumbs::for('home', function (Generator $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('store', function (Generator $trail) {
    $trail->parent('home');
    $trail->push('store', route('store.products'));
});

Breadcrumbs::for('category', function (Generator $trail, $category) {
    $trail->parent('home');
    $trail->push($category->slug, route('category.products', $category));
});

Breadcrumbs::for('collection', function (Generator $trail, $collection) {
    $trail->parent('home');
    $trail->push($collection->slug, route('collection.products', $collection));
});

Breadcrumbs::for('product', function (Generator $trail, $product) {
    $trail->parent('store');
    $trail->push($product->slug, route('single-product', $product));
});
