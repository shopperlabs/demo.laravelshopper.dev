@props([
    'product',
    'ifCart' => false
])

@php
    $class = ($ifCart) ? 'aspect-1 overflow-hidden '
        : 'aspect-h-1 aspect-w-1 w-full rounded-lg overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80';
@endphp

<div {{ $attributes->twMerge(['class' => $class]) }} >
    <img
        src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}"
        alt="{{ $product->name }} Thumbnail"
        class="object-cover object-center max-w-none lg:size-full"
    />
</div>
