<div class="bg-white">
    <div class="pt-10 pb-16 sm:pb-24">
        <x-container class="max-w-2xl mt-8">
             <!-- Product -->
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                 <!-- Image gallery -->
                <div class="flex flex-col-reverse">
                    @if ($product->getMedia(config('shopper.core.storage.collection_name'))->isNotEmpty())
                        <div class="hidden w-full max-w-2xl mx-auto mt-6 sm:block lg:max-w-none">
                            <div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">
                                @foreach ($product->getMedia(config('shopper.core.storage.collection_name')) as $image)
                                    <x-products.gallery-button :image="$image" :product="$product" :index="$loop->index" />
                                @endforeach
                            </div>
                        </div>

                        <div class="w-full aspect-h-1 aspect-w-1">
                            <!-- Tab panel, show/hide based on tab state. -->
                            <x-products.gallery :images="$product->getMedia(config('shopper.core.storage.collection_name'))" />
                        </div>
                    @endif


                </div>

                <!-- Product info -->
                <div class="px-4 mt-10 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $product->name }}</h1>
                    <div class="mt-3">
                        <h2 class="sr-only">{{ __('Product information') }}</h2>
                        <x-products.price :product="$product" class="text-base font-medium text-gray-900" />
                    </div>
                    <!-- Reviews -->
                    <div class="mt-3">
                        <h3 class="sr-only">{{ __('Reviews') }}</h3>
                        <x-products.reviews />
                    </div>

                    <div class="mt-6">
                        <h3 class="sr-only">{{ __('Description') }}</h3>
                        <div class="prose-sm prose text-gray-600 lg:max-w-none">{!! $product->description !!}</div>
                    </div>

                    <livewire:variants-selector :product="$product" />
                    {{--
                    <section aria-labelledby="details-heading" class="mt-12">
                        <h2 id="details-heading" class="sr-only">{{ __('Additional details') }}</h2>
                        <x-products.additionnal-infos />
                    </section> --}}
                </div>
            </div>
            @if ($product->relatedProducts->isnotEmpty())
                <section aria-labelledby="related-heading" class="px-4 py-16 mt-10 border-t border-gray-200 sm:px-0">
                    <h2 class="text-xl font-bold text-gray-900">{{ __('Customers also bought') }}</h2>

                    <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                        @foreach($product->relatedProducts as $relatedProduct)
                            <x-products.others :product="$relatedProduct"/>
                        @endforeach
                    </div>
                </section>
            @endif
        </x-container>
    </div>
</div>
