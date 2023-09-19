<div class="mx-auto max-w-xl pt-6 pb-12 sm:pb-16 lg:max-w-none">
    <h2 class="text-2xl font-bold tracking-tight text-secondary-900">{{ __('Shop by Collection') }}</h2>
    <p class="mt-4 text-base text-secondary-500">
        {{ __('Each season, we collaborate with world-class designers to create a collection inspired by the natural world.') }}
    </p>

    <div class="mt-10 space-y-12 lg:grid lg:grid-cols-3 lg:gap-x-8 lg:space-y-0">
        @foreach($collections as $collection)
            <a href="#" class="group block" id="collection-{{ $collection->id }}">
                <div aria-hidden="true" class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg lg:aspect-h-6 lg:aspect-w-5 group-hover:opacity-75">
                    <img src="{{ $collection->getFirstMediaUrl(config('shopper.core.storage.collection_name')) }}" alt="{{ $collection->seo_title }}" class="h-full w-full object-cover object-center">
                </div>
                <h3 class="mt-4 text-base font-semibold text-secondary-900">
                    {{ $collection->name }}
                </h3>
                @if($collection->description)
                    <p class="mt-2 text-sm text-secondary-500">
                        {{ $collection->description }}
                    </p>
                @endif
            </a>
        @endforeach
    </div>
</div>
