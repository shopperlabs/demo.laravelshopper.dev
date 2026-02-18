<div>
    <div class="relative overflow-hidden isolate">
        <svg class="absolute inset-0 -z-10 size-full stroke-zinc-200 mask-[radial-gradient(100%_100%_at_top_right,white,transparent)]"
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
                <p class="mt-4 text-xl text-zinc-500">
                    {{ __('This year, our new Matanga collection will shelter you from the harsh elements of a world that doesn\'t care if you live or die..') }}
                </p>
            </div>
            <div class="py-10">
                <!-- Decorative image grid -->
                @include('includes._decorative_images')

                <flux:button variant="primary" :href="route('store')" class="group">
                    {{ __('Discover now') }}
                    <span
                        class="ml-2 transition duration-200 ease-in-out transform translate-x-0 group-hover:translate-x-1">
                        <x-untitledui-arrow-narrow-right class="size-6" stroke-width="1.5" aria-hidden="true" />
                    </span>
                </flux:button>
            </div>
        </x-container>

        <x-stats />
    </div>

    @if ($products->isNotEmpty())
        <x-container class="py-12 lg:py-20">
            <div class="max-w-3xl lg:max-w-none">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-0">
                    <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 font-heading">
                        {{ __('Trending products') }}
                    </h2>
                    <x-link :href="route('store')" class="hidden text-sm font-semibold text-primary-600 hover:text-primary-500 sm:block">
                        See everything
                        <span aria-hidden="true"> →</span>
                    </x-link>
                </div>

                <div class="grid grid-cols-1 mt-6 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-x-8 lg:mt-18">
                    @foreach ($products as $product)
                        <x-products.card :$product />
                    @endforeach
                </div>
            </div>
        </x-container>
    @endif

    @if ($categories->isNotEmpty())
        <div>
            <x-container class="py-16 lg:pt-20">
                <div class="px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8 xl:px-0">
                    <h2 id="category-heading" class="text-2xl font-bold tracking-tight text-zinc-900">
                        {{ __('Shop by Category') }}
                    </h2>
                </div>
                <ul role="list" class="mt-4 grid gap-y-10 sm:grid-cols-2 sm:gap-x-8 lg:grid-cols-4 lg:gap-x-12">
                    @foreach ($categories as $category)
                        <li>
                            <x-categories.list :$category />
                        </li>
                    @endforeach
                </ul>
            </x-container>
        </div>
    @endif

    @if ($collections->isNotEmpty())
        <div class="bg-zinc-50">
            <x-container class="py-16 lg:py-24">
                <div class="max-w-xl pt-6 pb-12 mx-auto sm:pb-16 lg:max-w-none">
                    <h2 class="text-2xl font-bold tracking-tight text-zinc-900 font-heading">
                        {{ __('Shop by Collection') }}
                    </h2>
                    <p class="mt-4 text-base text-zinc-500">
                        {{ __('Each season, we collaborate with world-class designers to create a collection inspired by the natural world.') }}
                    </p>

                    <div class="mt-10 grid gap-8 lg:grid-cols-3 lg:gap-12">
                        @foreach ($collections as $collection)
                            <x-collections.card :$collection />
                        @endforeach
                    </div>
                </div>
            </x-container>
        </div>
    @endif
</div>
