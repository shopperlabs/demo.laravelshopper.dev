<?php

declare(strict_types=1);

namespace App\Adapters;

use Shopper\Core\Contracts\TaxableItem;
use Shopper\Core\Models\ProductVariant;

final readonly class CartItemTaxAdapter implements TaxableItem
{
    /**
     * @param  array<int, int>  $categoryIds
     */
    public function __construct(
        private int $price,
        private int $quantity,
        private ?string $productType,
        private ?int $productId,
        private array $categoryIds,
    ) {}

    public static function fromCartItem(mixed $item): self
    {
        $model = $item->associatedModel;
        $product = $model instanceof ProductVariant ? $model->product : $model;

        return new self(
            price: (int) $item->price,
            quantity: (int) $item->quantity,
            productType: $product->type?->value,
            productId: $product->id,
            categoryIds: $product->categories()->pluck('id')->all(),
        );
    }

    public function getTaxableAmount(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProductType(): ?string
    {
        return $this->productType;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /** @return array<int, int> */
    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }
}
