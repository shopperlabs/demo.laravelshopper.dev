<li>
    <div class="overflow-hidden shadow-lg aspect-w-2 aspect-h-1 rounded-xl">
        <img class="object-cover w-full h-full"
            src="{{ $category->getFirstMediaUrl(config('shopper.core.storage.collection_name')) }}"
            alt="{{ $category->name }}" />
    </div>
    <div class="px-4 mt-5">
        <h3 class="text-base font-medium leading-6 transition ease-in text-secondary-900 hover:text-black">
            <x-link href="#" class="inline-flex items-center">
                {{ $category->name }}
                <x-untitledui-arrow-narrow-right class="w-5 h-5 ml-2" />
            </x-link>
        </h3>
        <nav role="navigation" class="flex flex-col mt-3">
            @foreach ($category->children->take(6) as $child)
                <x-link href="#"
                    class="inline-flex text-sm leading-5 py-1.5 text-secondary-500 hover:text-secondary-900 transition ease-in">
                    {{ $child->name }}
                </x-link>
            @endforeach
            @if ($category->children->count() > 6)
                <x-link href="#"
                    class="mt-4 text-sm font-medium text-secondary-700 hover:text-secondary-900 group group-link-underline">
                    <span class="inline-flex items-center link link-underline link-underline-black">
                        <x-untitledui-plus class="w-4 h-4 mr-1" />
                        {{ __('View All') }}
                    </span>
                </x-link>
            @endif
        </nav>
    </div>
</li>
