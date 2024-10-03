@props([
    'product',
])

<p {{ $attributes->twMerge(['class' => 'text-sm font-medium text-gray-900']) }}>
    {{ $product->getPriceAmount()?->formatted }}
</p>
