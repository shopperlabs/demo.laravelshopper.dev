<?php

declare(strict_types=1);

namespace Database\Factories;

use Shopper\Core\Models\Product;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class ProductFactory extends \Shopper\Core\Database\Factories\ProductFactory
{
    public function configure(): \Shopper\Core\Database\Factories\ProductFactory
    {
        return $this->afterCreating(function (Product $product): void {
            try {
                $product
                    ->addMediaFromUrl('')
                    ->preservingOriginal()
                    ->toMediaCollection(config('shopper.core.storage.thumbnail_collection'));
            } catch (UnreachableUrl $exception) {
                return;
            }
        });
    }
}
