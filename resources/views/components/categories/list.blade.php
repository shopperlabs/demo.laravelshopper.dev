@props([
    'category',
])

<div class="space-y-5">
    <div class="overflow-hidden shadow-lg aspect-w-3 aspect-h-2 rounded-xl">
        <img class="object-cover max-w-none size-full"
            src="{{ $category->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}"
            alt="{{ $category->name }}" />
    </div>
    <div class="px-4">
        <h3 class="text-base font-medium leading-6 transition ease-in text-gray-700 hover:text-gray-900">
            <x-link href="#" class="inline-flex items-center  gap-2">
                {{ $category->name }}
                <x-untitledui-arrow-narrow-right class="size-5" aria-hidden="true" />
            </x-link>
        </h3>
        <nav role="navigation" class="flex flex-col mt-3">
            @foreach ($category->children->take(6) as $child)
                <x-link href="#" class="inline-flex text-sm leading-5 py-1.5 text-gray-500 hover:text-gray-900 transition ease-in">
                    {{ $child->name }}
                </x-link>
            @endforeach
            @if ($category->children->count() > 6)
                <x-link href="#" class="mt-4 text-sm font-medium text-gray-700 hover:text-gray-900 group group-link-underline">
                    <span class="inline-flex items-center gap-2 link link-underline link-underline-black">
                        <x-untitledui-plus class="size-4" aria-hidden="true" />
                        {{ __('View All') }}
                    </span>
                </x-link>
            @endif
        </nav>
    </div>
</div>
