<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

Breadcrumbs::for('home', function (Generator $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('store', function (Generator $trail) {
    $trail->parent('home');
    $trail->push('Store', route('store.products'));
});

Breadcrumbs::for('category', function (Generator $trail, $category) {
    $trail->parent('home');
    $trail->push($category->name, route('category.products', $category));
});

Breadcrumbs::for('collection', function (Generator $trail, $collection) {
    $trail->parent('home');
    $trail->push($collection->name, route('collection.products', $collection));
});

Breadcrumbs::for('product', function (Generator $trail, $product, $variant = null) {
    $trail->parent('store');
    $trail->push($product->name, route('single-product', $product));
});
