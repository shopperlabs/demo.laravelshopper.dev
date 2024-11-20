<div class="bg-white">
    <div class="pt-10 pb-16 sm:pb-24">
        <x-container class="max-w-2xl mt-8">
             <!-- Product -->
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                 <!-- Image gallery -->
                <div class="flex flex-col">

                    <x-products.thumbnail :product="$product" :currentVariant="$currentVariant"/>

                    @if ($product->getMedia(config('shopper.core.storage.collection_name'))->isNotEmpty())
                        <div class="hidden w-full max-w-2xl mx-auto mt-6 sm:block lg:max-w-none">
                            <div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">
                                @foreach ($product->getMedia(config('shopper.core.storage.collection_name')) as $image)
                                    <div class="relative flex items-center justify-center h-24 bg-white rounded-lg overflow-hidden">
                                        <img
                                            src="{{ $image->getFullUrl() }}"
                                            alt="{{ $product->name }} image"
                                            class="object-cover object-center size-full"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product info -->
                <div class="px-4 mt-10 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $product->name}} {{ (isset($currentVariant)) ? '/ '.$currentVariant->name : ''  }} </h1>
                    <div class="mt-3">
                        <h2 class="sr-only">{{ __('Product information') }}</h2>
                        <x-products.price :product="$product" :currentVariant="$currentVariant" class="text-base font-medium text-gray-900" />
                    </div>
                    <!-- Reviews -->
                    <div class="mt-3">
                        <h3 class="sr-only">{{ __('Reviews') }}</h3>
                        <x-products.reviews />
                    </div>

                    <livewire:variants-selector :product="$product" :currentVariant="$currentVariant"/>

                    <div class="mt-6">
                        <h3 class="sr-only">{{ __('Description') }}</h3>
                        <div class="prose-sm prose text-gray-600 lg:max-w-none">{!! $product->description !!}</div>
                    </div>


                </div>
            </div>

            @if ($product->variants->isnotEmpty())
                <section aria-labelledby="related-heading" class="px-4 py-16 mt-10 border-t border-gray-200 sm:px-0">
                    <h2 class="text-xl font-bold text-gray-900">{{ __('A few variants') }}</h2>

                    <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                        @foreach($product->variants as $variant)
                            <div>
                                <div class="relative">
                                    <div class="relative w-full overflow-hidden rounded-lg h-72">
                                        <img
                                            src="{{ $variant->getFirstMediaUrl(config('shopper.core.storage.collection_name')) }}"
                                            alt="{{ $variant->name }} thumbnail"
                                            class="object-cover object-center w-full h-full"
                                        />
                                    </div>
                                    <div class="relative mt-4">
                                        <x-link :href="route('single-product', ['slug' => $product->slug])">
                                            <span class="absolute inset-0"></span>
                                            {{ $variant->name }}
                                        </x-link>
                                    </div>
                                    <div class="absolute inset-x-0 top-0 flex items-end justify-end p-4 overflow-hidden rounded-lg h-72">
                                        <div aria-hidden="true" class="absolute inset-x-0 bottom-0 opacity-50 h-36 bg-gradient-to-t from-black">
                                        </div>
                                        <x-products.price :product="$variant" class="relative text-lg font-semibold text-white" />
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <x-buttons.primary
                                        type="button"
                                        wire:click="addToCart({{ $variant->id }})"
                                        class="relative flex items-center justify-center px-8 py-2 text-sm font-medium bg-gray-100 border border-transparent rounded-md hover:bg-gray-200"
                                    >
                                        {{ __('Add to cart')}}
                                        <span class="sr-only">{{ $variant->name }}</span>
                                    </x-buttons.primary>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($product->relatedProducts->isnotEmpty())
                <section aria-labelledby="related-heading" class="px-4 py-16 mt-10 border-t border-gray-200 sm:px-0">
                    <h2 class="text-xl font-bold text-gray-900">{{ __('Customers also bought') }}</h2>

                    <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                        @foreach($product->relatedProducts as $relatedProduct)
                            <x-products.related :product="$relatedProduct"/>
                        @endforeach
                    </div>
                </section>
            @endif
        </x-container>
    </div>
</div>
