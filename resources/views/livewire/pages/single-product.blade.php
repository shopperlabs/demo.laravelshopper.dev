<div class="bg-white">
    <div class="py-3 bg-white/80 border-b border-zinc-200">
        <x-container class="flex items-center justify-between px-4">
            {{ Breadcrumbs::render('product', $product) }}
        </x-container>
    </div>

    <x-container class="pt-10 pb-16 sm:pb-24">
        <!-- Product -->
        <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
            <!-- Image gallery -->
            <div class="flex flex-col">
                <x-products.thumbnail :product="$selectedVariant ?? $product" />

                @php
                    $galleryMedia = $selectedVariant?->getMedia(config('shopper.media.storage.collection_name'));
                    $galleryMedia = $galleryMedia?->isNotEmpty() ? $galleryMedia : $product->getMedia(config('shopper.media.storage.collection_name'));
                @endphp

                @if ($galleryMedia->isNotEmpty())
                    <div class="hidden w-full max-w-2xl mx-auto mt-6 sm:block lg:max-w-none lg:mt-10">
                        <div class="grid grid-cols-4 gap-6 sm:grid-cols-6" aria-orientation="horizontal" role="tablist">
                            @foreach ($galleryMedia as $image)
                                <div
                                    class="relative flex items-center justify-center aspect-square ring-1 ring-zinc-200 bg-white rounded-lg overflow-hidden">
                                    <img src="{{ $image->getFullUrl() }}" alt="{{ ($selectedVariant ?? $product)->name }} image"
                                         class="object-cover object-center size-full" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Product info -->
            <div class="px-4 mt-10 sm:mt-16 sm:px-0 lg:mt-0">
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900">
                    {{ $product->name }}
                    @isset($selectedVariant)
                        <span> / {{ $selectedVariant->name }}</span>
                    @endisset
                </h1>

                @if ($product->summary)
                    <p class="mt-2 text-sm/4 text-zinc-500">{{ $product->summary }}</p>
                @endif

                @if ($product->brand_id)
                    <a
                        :href="{{ $product->brand->website ?? '#' }}"
                        target="_blank"
                        class="cursor-default mt-4 inline-flex font-medium text-primary-500 group group-link-underline"
                    >
                        <span class="link link-underline link-underline-primary">
                        {{ $product->brand->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1 size-3" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                @endif

                <div class="mt-4 flex items-center gap-3">
                    <h2 class="sr-only">{{ __('Product information') }}</h2>
                    <x-products.price
                        :product="$selectedVariant ?? $product"
                        class="text-base font-medium text-zinc-900"
                    />
                    @if ($product->isVariant() ? ($selectedVariant && $selectedVariant->stock < 1) : $product->stock < 1)
                        <flux:badge color="red" size="sm">{{ __('Out of stock') }}</flux:badge>
                    @endif
                </div>
                <!-- Reviews -->
                <div class="mt-3">
                    <h3 class="sr-only">{{ __('Reviews') }}</h3>
                    <x-products.reviews :rating="$averageRating" />
                </div>

                <livewire:variants-selector
                    :$product
                    :selectedVariant="$selectedVariant"
                />

                <div class="mt-6">
                    <h3 class="sr-only">{{ __('Description') }}</h3>
                    <div class="prose prose-sm text-zinc-500">
                        {!! clean($product->description) !!}
                    </div>
                </div>
            </div>
        </div>

        @if ($product->relatedProducts->isnotEmpty())
            <section aria-labelledby="related-heading" class="px-4 py-16 mt-10 border-t border-zinc-200 sm:px-0">
                <h2 class="text-xl font-bold text-zinc-900">{{ __('Customers also bought') }}</h2>

                <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($product->relatedProducts as $related)
                        <x-products.card :product="$related" />
                    @endforeach
                </div>
            </section>
        @endif

        <livewire:product.reviews :$product />
    </x-container>
</div>
