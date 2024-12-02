@props([
    'product',
])

<p {{ $attributes->twMerge(['class' => 'inline-flex items-center gap-2 text-sm text-gray-600']) }}>
    {{ $product->getPriceAmount()?->formatted }}

    @if($product->discount_percentage && $product->discount_percentage > 0)
        <span>
            <span class="sr-only">{{ __('Original :') }}</span>
            <span class="text-gray-400 line-through">
                {{ $product->getOldPriceAmount()?->formatted }}
            </span>
            <x-badges.discount
                :discount="$product->discount_percentage"
                class="ml-2"
            />
        </span>
    @endif
</p>
