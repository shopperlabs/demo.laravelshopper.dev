<x-link href="#" class="block group" id="collection-{{ $collection->id }}">
    <div aria-hidden="true"
        class="overflow-hidden rounded-lg aspect-h-2 aspect-w-3 lg:aspect-h-6 lg:aspect-w-5 group-hover:opacity-75">
        <img src="{{ $collection->getFirstMediaUrl(config('shopper.core.storage.collection_name')) }}"
            alt="{{ $collection->seo_title }}" class="object-cover object-center w-full h-full">
    </div>
    <h3 class="mt-4 text-base font-semibold text-secondary-900">
        {{ $collection->name }}
    </h3>
    @if ($collection->description)
        <p class="mt-2 text-sm text-secondary-500">
            {{ $collection->description }}
        </p>
    @endif
</x-link>
