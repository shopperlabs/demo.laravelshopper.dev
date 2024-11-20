@props([
    'product',
    'currentVariant' => null,
])

<p {{ $attributes->twMerge(['class' => 'inline-flex items-center gap-2 text-sm text-gray-600']) }}>
<<<<<<< HEAD
    {{ (!$currentVariant) ? $product->getPriceAmount()?->formatted : $currentVariant->getPriceAmount()?->formatted }}
=======
    {{ $product->getPriceAmount()?->formatted }}

>>>>>>> a1104e4 (:feat:[SHO-54] add products variants in single product detail page and fix discount percent)
    @if(isset($product->discount_percentage) && $product->discount_percentage !== 0 && $product->getOldPriceAmount())
        <span>
            <span class="sr-only">
                {{ __('Original :') }}
            </span>
            <span class="text-gray-400 line-through">
                {{ (!$currentVariant) ? $product->getPriceAmount()?->formatted : $currentVariant->getPriceAmount()?->formatted }}
            </span>
            <x-badges.discount
                :discount=" (!$currentVariant) ? $product->discount_percentage : $currentVariant->discount_percentage"
                class="ml-2"
            />
        </span>
    @endif
</p>
