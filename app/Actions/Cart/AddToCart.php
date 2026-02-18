<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\DTO\PriceData;
use App\Models\Product;
use App\Models\ProductVariant;
use Darryldecode\Cart\Facades\CartFacade;
use InvalidArgumentException;

final class AddToCart
{
    /**
     * @throws InvalidArgumentException
     */
    public function handle(Product $product, ?ProductVariant $variant = null): void
    {
        $model = $variant ?? $product;

        $priceData = $model->getFormattedPrice();

        if (! $priceData instanceof PriceData) {
            throw new InvalidArgumentException(__('This product has no price configured.'));
        }

        if ($model->stock < 1 && ! ($model->allow_backorder ?? false)) {
            throw new InvalidArgumentException(__('This product is out of stock.'));
        }

        $attributes = [];

        if ($variant instanceof ProductVariant) {
            $variant->loadMissing('values.attribute');
            $attributes = $variant->values->mapWithKeys(fn ($value): array => [$value->attribute->name => $value->value])->all();
        }

        // @phpstan-ignore-next-line
        CartFacade::session(session()->getId())->add([
            'id' => $model->id,
            'name' => $product->name,
            'price' => $priceData->amount->amount,
            'quantity' => 1,
            'attributes' => $attributes,
            'associatedModel' => $model,
        ]);
    }
}
