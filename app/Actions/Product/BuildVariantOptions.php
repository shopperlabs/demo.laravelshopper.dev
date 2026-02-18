<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use App\Models\ProductVariant;
use Exception;
use Shopper\Core\Enum\FieldType;

final class BuildVariantOptions
{
    /**
     * @return array{
     *     productOptions: array<int, array{id: int, name: string, slug: string, type: string, values: array<int, array{id: int, value: string, key: string, image: ?string}>}>,
     *     variantIndex: array<string, int>,
     *     variantMap: array<int, array{id: int, values: array<int, int>, stock: int, allow_backorder: bool}>,
     *     hasStructuredAttributes: bool,
     *     availabilityMatrix: array<int, array<int, bool>>
     * }
     *
     * @throws Exception
     */
    public function handle(Product $product): array
    {
        $product->loadMissing('variants.values.attribute');

        $variantMap = $this->buildVariantMap($product);
        $variantIndex = $this->buildVariantIndex($variantMap);
        $productOptions = $this->buildProductOptions($product);
        $hasStructuredAttributes = count($productOptions) > 0;

        $availabilityMatrix = $hasStructuredAttributes
            ? resolve(ResolveVariantAvailability::class)->handle($variantMap, [], $productOptions)
            : [];

        return [
            'productOptions' => $productOptions,
            'variantIndex' => $variantIndex,
            'variantMap' => $variantMap,
            'hasStructuredAttributes' => $hasStructuredAttributes,
            'availabilityMatrix' => $availabilityMatrix,
        ];
    }

    /**
     * @return array<int, array{id: int, values: array<int, int>, stock: int, allow_backorder: bool}>
     */
    private function buildVariantMap(Product $product): array
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, ProductVariant> $variants */
        $variants = $product->variants;

        return $variants->map(fn (ProductVariant $variant): array => [
            'id' => $variant->id,
            'values' => $variant->values->pluck('id')->all(),
            'stock' => $variant->stock,
            'allow_backorder' => $variant->allow_backorder,
        ])->all();
    }

    /**
     * @param  array<int, array{id: int, values: array<int, int>, stock: int, allow_backorder: bool}>  $variantMap
     * @return array<string, int>
     */
    private function buildVariantIndex(array $variantMap): array
    {
        $index = [];

        foreach ($variantMap as $variant) {
            $key = $this->makeVariantKey($variant['values']);
            $index[$key] = $variant['id'];
        }

        return $index;
    }

    /**
     * @param  array<int, int>  $valueIds
     */
    private function makeVariantKey(array $valueIds): string
    {
        $sorted = $valueIds;
        sort($sorted);

        return implode('-', $sorted);
    }

    /**
     * @return array<int, array{id: int, name: string, slug: string, type: string, values: array<int, array{id: int, value: string, key: string, image: ?string}>}>
     */
    private function buildProductOptions(Product $product): array
    {
        $grouped = collect();
        $thumbnailCollection = config('shopper.media.storage.thumbnail_collection');

        foreach ($product->variants as $variant) {
            foreach ($variant->values as $value) {
                $attrId = $value->attribute_id;

                if (! $grouped->has($attrId)) {
                    $grouped->put($attrId, [
                        'id' => $attrId,
                        'name' => $value->attribute->name,
                        'slug' => $value->attribute->slug,
                        'type' => $value->attribute->type->value,
                        'values' => collect(),
                    ]);
                }

                $attr = $grouped->get($attrId);

                if (! $attr['values']->contains('id', $value->id)) {
                    $image = null;

                    if ($value->attribute->type === FieldType::ColorPicker) {
                        $image = $variant->getFirstMediaUrl($thumbnailCollection) ?: null;
                    }

                    $attr['values']->push([
                        'id' => $value->id,
                        'value' => $value->value,
                        'key' => $value->key,
                        'image' => $image,
                    ]);
                }

                $grouped->put($attrId, $attr);
            }
        }

        /**
         * @var array<int, array{
         *     id: int,
         *     name: string,
         *     slug: string,
         *     type: string,
         *     values: array<int, array{id: int, value: string, key: string, image: ?string}>
         * }>
         */
        return $grouped->map(function (array $attr): array {
            $attr['values'] = $attr['values']->sortBy('id')->values()->all();

            return $attr;
        })->values()->all();
    }
}
