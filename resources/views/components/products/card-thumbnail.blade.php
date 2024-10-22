@props([
    'product',
])

<div
    {{ $attributes->twMerge(['class' => 'h-56 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:h-72 xl:h-80']) }}
>
    <img
        src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}"
        alt="{{ $product->name }} Thumbnail"
        class="object-cover object-center w-full h-full"
    />
</div>
