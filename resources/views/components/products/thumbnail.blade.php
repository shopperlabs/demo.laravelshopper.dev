@props([
    'product',
    'containerClass' => null,
])

<div @class(['aspect-1 overflow-hidden', $containerClass])>
    <img
        src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}"
        alt="{{ $product->name }} thumbnail"
        {{ $attributes->twMerge(['class' => 'size-full max-w-none object-cover object-center group-hover:opacity-75']) }}
    />
</div>
