<div class="bg-white">
    <div class="pt-10 pb-16 sm:pb-24">
        <x-container class="max-w-2xl mt-8">
             <!-- Product -->
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                 <!-- Image gallery -->
                <div class="flex flex-col-reverse">
                    <div class="hidden w-full max-w-2xl mx-auto mt-6 sm:block lg:max-w-none">
                        <div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">
                            @if ($product->getMedia(config('shopper.core.storage.collection_name'))->isNotEmpty())
                                @foreach ($product->getMedia(config('shopper.core.storage.collection_name')) as $image)
                                    <x-products.gallery-button :image="$image" :product="$product" :index="$loop->index" />
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="w-full aspect-h-1 aspect-w-1">
                        <!-- Tab panel, show/hide based on tab state. -->
                        @if ($product->getMedia(config('shopper.core.storage.collection_name'))->isNotEmpty())
                            <x-products.gallery :images="$product->getMedia(config('shopper.core.storage.collection_name'))" />
                        @endif
                    </div>

                </div>

                <!-- Product info -->
                <div class="px-4 mt-10 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900"> {{ $product->name }}</h1>
                    <div class="mt-3">
                        <h2 class="sr-only">Product information</h2>
                        <x-products.price :product="$product" class="text-base font-medium text-gray-900" />
                    </div>
                    <!-- Reviews -->
                    <div class="mt-3">
                        <h3 class="sr-only">Reviews</h3>
                        <x-products.reviews />
                    </div>

                    <div class="mt-6">
                        <h3 class="sr-only">Description</h3>

                        <div class="space-y-6 text-base text-gray-700">
                            <p> {!! $product->description !!}</p>
                        </div>
                    </div>

                    <livewire:variants-selector :product="$product" />

                    <section aria-labelledby="details-heading" class="mt-12">
                        <h2 id="details-heading" class="sr-only">Additional details</h2>
                        <x-products.additionnal-infos />
                    </section>
                </div>
            </div>

            <section aria-labelledby="related-heading" class="px-4 py-16 mt-10 border-t border-gray-200 sm:px-0">
                <h2 id="related-heading" class="text-xl font-bold text-gray-900">Customers also bought</h2>

                <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                    <x-products.others  :product="$product"/>
                </div>
              </section>
        </x-container>
    </div>
</div>
