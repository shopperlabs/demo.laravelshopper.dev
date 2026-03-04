@blaze

@props([
    'product',
])

@php
    $price = $product->getFormattedPrice();
@endphp

<p {{ $attributes->twMerge(['class' => 'inline-flex items-center gap-2 text-sm']) }}>
    <span class="font-medium text-zinc-900">{{ $price?->amount->formatted }}</span>
    @if ($taxLabel = current_tax_label())
        <span class="text-xs text-zinc-500">{{ $taxLabel }}</span>
    @endif

    @if ($price && $price->percentage && $price->percentage > 0)
        <span>
            <span class="sr-only">{{ __('Original :') }}</span>
            <span class="text-zinc-400 line-through">
                {{ $price->compare->formatted }}
            </span>
            <x-badges.discount
                :discount="$price->percentage"
                class="ml-2"
            />
        </span>
    @endif
</p>
