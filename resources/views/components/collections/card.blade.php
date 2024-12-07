@props([
    'collection',
])

<x-link :href="route('collection.products' , $collection->slug)" class="block group" id="collection-{{ $collection->id }}">
    <div aria-hidden="true" class="overflow-hidden rounded-lg aspect-h-2 aspect-w-3 lg:aspect-h-6 lg:aspect-w-5 group-hover:opacity-75">
        <img
            class="object-cover object-center max-w-none size-full"
            src="{{ $collection->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection')) }}"
            alt="{{ $collection->seo_title }}"
        />
    </div>
    <h3 class="mt-4 text-base font-semibold text-gray-900 font-heading lg:text-lg">
        {{ $collection->name }}
    </h3>
    @if ($collection->description)
        <p class="mt-2 text-sm text-gray-500">
            {{ $collection->description }}
        </p>
    @endif
</x-link>
