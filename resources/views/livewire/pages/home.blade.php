<div>
    <div class="relative overflow-hidden isolate">
        <svg class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
            aria-hidden="true">
            <defs>
                <pattern id="0787a7c5-978c-4f66-83c7-11c213f99cb7" width="200" height="200" x="50%" y="-1"
                    patternUnits="userSpaceOnUse">
                    <path d="M.5 200V.5H200" fill="none" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#0787a7c5-978c-4f66-83c7-11c213f99cb7)" />
        </svg>

        <x-container class="relative py-16 sm:pt-24 lg:py-40">
            <div class="sm:max-w-xl">
                <h1 class="text-4xl font-bold tracking-tight text-black font-heading sm:text-6xl">
                    {{ __('Matanga styles are finally here') }}
                </h1>
                <p class="mt-4 text-xl text-gray-500">
                    {{ __('This year, our new Matanga collection will shelter you from the harsh elements of a world that doesn\'t care if you live or die..') }}
                </p>
            </div>
            <div class="py-10">
                <!-- Decorative image grid -->
                @include('includes._decorative_images')

                <x-buttons.primary :href="route('store.products')" class="px-8 py-3 text-base font-medium text-center group">
                    {{ __('Discover now') }}
                    <span
                        class="ml-2 transition duration-200 ease-in-out transform translate-x-0 group-hover:translate-x-1">
                        <x-untitledui-arrow-narrow-right class="size-6" stroke-width="1.5" aria-hidden="true" />
                    </span>
                </x-buttons.primary>
            </div>
        </x-container>

        <x-stats />
    </div>

    @if ($categories->isNotEmpty())
        <div>
            <x-container class="py-16 lg:pt-20">
                <ul role="list" class="grid gap-y-10 sm:grid-cols-2 sm:gap-x-8 lg:grid-cols-4 lg:gap-x-12">
                    @foreach ($categories->toTree() as $category)
                        <li>
                            <x-categories.list :category="$category" />
                        </li>
                    @endforeach
                </ul>
            </x-container>
        </div>
    @endif

    <div class="bg-gray-50">
        @if ($collections->isNotEmpty())
            <x-container class="py-16 lg:py-24">
                <div class="max-w-xl pt-6 pb-12 mx-auto sm:pb-16 lg:max-w-none">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 font-heading">
                        {{ __('Shop by Collection') }}
                    </h2>
                    <p class="mt-4 text-base text-gray-500">
                        {{ __('Each season, we collaborate with world-class designers to create a collection inspired by the natural world.') }}
                    </p>

                    <div class="mt-10 grid gap-8 lg:grid-cols-3 lg:gap-12">
                        @foreach ($collections as $collection)
                            <x-collections.card :collection="$collection" />
                        @endforeach
                    </div>
                </div>
            </x-container>
        @endif
    </div>

    @if ($products->isNotEmpty())
        <x-container class="py-12 lg:py-20">
            <div class="max-w-3xl lg:max-w-none">
                <h2 class="text-2xl font-semibold tracking-tight text-gray-900 font-heading">
                    {{ __('Trending products') }}
                </h2>

                <div class="grid grid-cols-1 mt-6 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-x-8">
                    @foreach ($products as $product)
                        <x-products.card :product="$product" />
                    @endforeach
                </div>
            </div>
        </x-container>
    @endif
</div>
