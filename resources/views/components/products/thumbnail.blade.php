@props([
    'product',
])

<div
    {{ $attributes->twMerge(['class' => 'overflow-hidden bg-gray-200 group-hover:opacity-75']) }}
>
    <img
        src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}"
        alt="{{ $product->name }} Thumbnail"
        class="object-cover object-center w-full h-full max-w-none lg:h-full lg:w-full"
    />
</div>
