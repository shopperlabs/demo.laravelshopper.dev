<?php

declare(strict_types=1);

namespace App\Actions\Product;

final class ResolveVariantAvailability
{
    /**
     * @param  array<int, array{id: int, values: array<int, int>, stock: int, allow_backorder: bool}>  $variantMap
     * @param  array<int, int>  $selectedOptions  [attribute_id => value_id]
     * @param  array<int, array{id: int, name: string, slug: string, type: string, values: array<int, array{id: int, value: string, key: string, image: ?string}>}>  $productOptions
     * @return array<int, array<int, bool>> [attribute_id => [value_id => available]]
     */
    public function handle(array $variantMap, array $selectedOptions, array $productOptions): array
    {
        $matrix = [];

        foreach ($productOptions as $attribute) {
            $attrId = $attribute['id'];
            $matrix[$attrId] = [];

            foreach ($attribute['values'] as $value) {
                $valueId = $value['id'];

                $constraints = collect($selectedOptions)
                    ->except([$attrId])
                    ->put($attrId, $valueId);

                $matrix[$attrId][$valueId] = collect($variantMap)
                    ->contains(function (array $variant) use ($constraints): bool {
                        foreach ($constraints as $valId) {
                            if (! in_array($valId, $variant['values'], true)) {
                                return false;
                            }
                        }

                        return $variant['stock'] > 0 || $variant['allow_backorder'];
                    });
            }
        }

        return $matrix;
    }
}
