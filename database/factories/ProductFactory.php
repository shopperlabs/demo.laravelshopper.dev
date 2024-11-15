<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Database\Seeders\LocalImages;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class ProductFactory extends \Shopper\Core\Database\Factories\ProductFactory
{
    protected $model = Product::class;

    public function configure(): ProductFactory
    {
        return $this->afterCreating(function (Product $product) {
            try {
                $product
                    ->addMedia(LocalImages::getRandomFile())
                    ->preservingOriginal()
                    ->toMediaCollection(config('shopper.core.storage.thumbnail_collection'));
            } catch (UnreachableUrl $exception) {
                return;
            }
        });
    }
}
