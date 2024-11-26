@props([
    'product',
    'containerClass' => null,
    'currentVariant' => null
])

<div @class(['aspect-1 overflow-hidden', $containerClass])>
    <img
        src="{{ (!$currentVariant)
              ? $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection'))
              : $currentVariant->getFirstMediaUrl(config('shopper.core.storage.collection_name')) }}"
        alt="{{ (!$currentVariant)
                ? $product->name
                : $currentVariant }} thumbnail"
        {{ $attributes->twMerge(['class' => 'size-full max-w-none object-cover object-center group-hover:opacity-75']) }}
    />
</div>
