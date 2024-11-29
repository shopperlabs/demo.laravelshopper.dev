@props([
    'product',
    'currentVariant' => null,
])

<p {{ $attributes->twMerge(['class' => 'inline-flex items-center gap-2 text-sm text-gray-600']) }}>
    {{ (!$currentVariant) ? $product->getPriceAmount()?->formatted : $currentVariant->getPriceAmount()?->formatted }}
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
