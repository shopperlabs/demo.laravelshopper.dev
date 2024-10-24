<div class="bg-white">
    <div class="pt-10 pb-16 sm:pb-24">
        <x-container class="max-w-2xl mt-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
                <div class="lg:col-span-3">
                    <aside class="space-y-10 lg:sticky lg:top-40" aria-labelledby="product-description">
                        <div>
                            <h2 class="text-sm font-medium text-gray-900">{{ __('Description') }}</h2>

                            <div class="mt-4 prose-sm prose text-gray-500">
                                {!! $product->description !!}
                            </div>
                        </div>

                        <x-products.additionnal-infos />
                    </aside>
                </div>

                <!-- Product gallery -->
                <div class="lg:col-span-6 lg:px-8">
                    <h2 class="sr-only">{{ $product->name }} {{ __('Images') }}</h2>

                    <div
                        @class([
                            'grid grid-cols-1 lg:grid-cols-2 lg:gap-8',
                            'lg:grid-rows-3' => $product->getMedia(config('shopper.core.storage.collection_name'))->isNotEmpty()
                        ])
                    >
                        <div class="lg:col-span-2 lg:row-span-2">
                            <img
                                src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}"
                                alt="{{ $product->name }} thumbnail"
                                class="object-cover w-full h-full"
                            />
                        </div>
                        @if($product->getMedia(config('shopper.core.storage.collection_name'))->isNotEmpty())
                            <x-products.gallery
                                :images="$product->getMedia(config('shopper.core.storage.collection_name'))"
                            />
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <aside class="space-y-10 lg:sticky lg:top-40" aria-labelledby="product-variant">
                        <div>
                            <div class="space-y-1">
                                <h1 class="text-xl font-semibold text-gray-900 font-heading lg:text-2xl">
                                    {{ $product->name }}
                                </h1>
                                <x-products.price :product="$product" class="text-base font-medium text-gray-900" />
                            </div>
                        </div>

                        <livewire:variants-selector :product="$product" />

                        <!-- Policies -->
                        <section aria-labelledby="policies-heading">
                            <h2 id="policies-heading" class="sr-only">{{ __('Our policies') }}</h2>

                            <dl class="space-y-4">
                                <div class="p-6 border border-gray-200 bg-gray-50">
                                    <dt class="flex items-center gap-2">
                                        <x-untitledui-globe-05 class="w-6 h-6 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                                        <span class="text-sm font-medium text-gray-900">{{ __('International delivery') }}</span>
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-500">
                                        {{ __('Get your order in 2 weeks') }}
                                    </dd>
                                </div>
                                <div class="p-6 border border-gray-200 bg-gray-50">
                                    <dt class="flex items-center gap-2">
                                        <x-untitledui-gift-02 class="w-6 h-6 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                                        <span class="text-sm font-medium text-gray-900">{{ __('Fidelity rewards') }}</span>
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-500">
                                        {{ __('Get discounts and bonuses for your loyalty.') }}
                                    </dd>
                                </div>
                            </dl>
                        </section>
                    </aside>
                </div>
            </div>
        </x-container>
    </div>
</div>
