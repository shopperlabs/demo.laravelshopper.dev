@props([
    'product',
])

<div
    {{ $attributes->twMerge(['class' => 'aspect-h-1 aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80']) }}
>
    <img
        src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}"
        alt="{{ $product->name }} Thumbnail"
        class="object-cover object-center w-full h-full max-w-none lg:h-full lg:w-full"
    />
</div>
