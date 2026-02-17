@props([
    'collection',
])

<x-link :href="route('collection.products' , $collection->slug)" class="block group" id="collection-{{ $collection->id }}">
    <div aria-hidden="true" class="overflow-hidden rounded-lg ring-1 ring-zinc-200 aspect-3/2 group-hover:opacity-75">
        <img
            class="object-cover object-center max-w-none size-full"
            src="{{ $collection->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection')) }}"
            alt="{{ $collection->seo_title }}"
        />
    </div>
    <h3 class="mt-4 text-base font-semibold text-zinc-900 font-heading lg:text-lg">
        {{ $collection->name }}
    </h3>
</x-link>
