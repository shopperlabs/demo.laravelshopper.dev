<div class="bg-white">
    <div class="py-3 bg-white border-b border-gray-200 bg-opacity-80">
        <x-container class="flex items-center justify-between px-4">
            {{ Breadcrumbs::render('product', $product) }}
        </x-container>
    </div>

    <div class="pt-10 pb-16 sm:pb-24">
        <x-container class="max-w-2xl mt-8">
            <!-- Product -->
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <!-- Image gallery -->
                <div class="flex flex-col">

                    <x-products.thumbnail :product="$selectedVariant ?? $product" />

                    @if ($product->getMedia(config('shopper.media.storage.collection_name'))->isNotEmpty())
                        <div class="hidden w-full max-w-2xl mx-auto mt-6 sm:block lg:max-w-none">
                            <div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">
                                @foreach ($product->getMedia(config('shopper.media.storage.collection_name')) as $image)
                                    <div
                                        class="relative flex items-center justify-center h-24 bg-white rounded-lg overflow-hidden">
                                        <img src="{{ $image->getFullUrl() }}" alt="{{ $product->name }} image"
                                            class="object-cover object-center size-full" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product info -->
                <div class="px-4 mt-10 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                        {{ $product->name}}
                        @isset($selectedVariant)
                            <span> / {{ $selectedVariant->name }}</span>
                        @endisset
                    </h1>
                    <div class="mt-3">
                        <h2 class="sr-only">{{ __('Product information') }}</h2>
                        <x-products.price
                            :product="$selectedVariant ?? $product"
                            class="text-base font-medium text-gray-900"
                        />
                    </div>
                    <!-- Reviews -->
                    <div class="mt-3">
                        <h3 class="sr-only">{{ __('Reviews') }}</h3>
                        <x-products.reviews :rating="$this->averageRating" />
                    </div>

                    <livewire:variants-selector
                        :product="$product"
                        :selectedVariant="$selectedVariant"
                    />

                    <div class="mt-6">
                        <h3 class="sr-only">{{ __('Description') }}</h3>
                        <div class="prose-sm prose text-gray-600 lg:max-w-none">{!! $product->description !!}</div>
                    </div>
                </div>
            </div>

            @if ($product->relatedProducts->isnotEmpty())
                <section aria-labelledby="related-heading" class="px-4 py-16 mt-10 border-t border-gray-200 sm:px-0">
                    <h2 class="text-xl font-bold text-gray-900">{{ __('Customers also bought') }}</h2>

                    <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                        @foreach ($product->relatedProducts as $product)
                            <div class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
                                <x-products.thumbnail :product="$product"  class="aspect-[3/4] bg-gray-200 object-cover group-hover:opacity-75 sm:h-96" />
                                <div class="flex flex-1 flex-col space-y-2 p-4">
                                    <h3 class="text-sm font-medium text-gray-900">
                                        <x-link :href="route('single-product', $product)">
                                            <span class="absolute inset-0"></span>
                                            {{ $product->name }}
                                        </x-link>
                                    </h3>
                                    <div class="flex flex-1 flex-col justify-end">
                                        <x-products.price :product="$product" class="mt-1" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <livewire:product.reviews :product="$product->load('ratings')" />
        </x-container>
    </div>
</div>
