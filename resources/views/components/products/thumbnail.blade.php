@props([
    'product',
])

<div
    {{ $attributes->twMerge(['class' => 'aspect-h-1 aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80']) }}
>
    <img
        src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}"
        alt="{{ $product->name }} Thumbnail"
        class="h-full w-full max-w-none object-cover object-center lg:h-full lg:w-full"
    />
</div>
