<div class="bg-white">
    <div class="pb-16 sm:pb-24">
        <x-container class="max-w-2xl">
            <div class="mx-auto">
                <div class="border-b border-gray-200 pb-4 pt-8 mb-2">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900">{{ __('Store') }}</h1>
                    <p class="mt-4 text-base text-gray-500">
                        {{  __('Discover a wide range of products for a new and enriching experience!') }}
                    </p>
                </div>
                <div class="pb-24 pt-12 lg:grid lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-4">
                    <aside>
                        <h2 class="sr-only">Filters</h2>
                        <!-- Mobile filter dialog toggle, controls the 'mobileFilterDialogOpen' state. -->
                        <button type="button" class="inline-flex items-center lg:hidden">
                            <span class="text-sm font-medium text-gray-700">Filters</span>
                            <svg class="ml-1 size-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>
                        </button>

                        <div class="hidden w-72 lg:block">
                            <div class="divide-y divide-gray-200">
                                @foreach($attributes as $attribute)
                                    @if(\Illuminate\Support\Facades\View::exists('components.attributes.'.$attribute->slug))
                                        <x-dynamic-component :component="'attributes.'.$attribute->slug" :attribute="$attribute" />
                                    @else
                                        <div wire:key="{{ $attribute->id }}" class="py-6">
                                            <p class="block text-sm font-medium text-gray-900">{{ $attribute->name }}</p>
                                            @if ($attribute->values->isNotEmpty())
                                                <div class="space-y-3 pt-6">
                                                    @foreach ($attribute->values as $index => $value)
                                                        <div class="flex items-center" wire:key="{{ $attribute->slug }}-{{ $value->key }}">
                                                            <input
                                                                id="{{ $attribute->slug }}-{{ $index }}"
                                                                wire:model.live.debounce.350ms="selectedAttributes"
                                                                value="{{ $value->id }}"
                                                                type="checkbox"
                                                                class="size-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                                                            >
                                                            <label for="{{ $attribute->slug }}-{{ $index }}" class="ml-3 text-sm text-gray-600">{{ $value->value }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </aside>

                    @if ($products->isNotEmpty())
                        <section aria-labelledby="product-heading" class="mt-6 lg:col-span-2 lg:mt-0 xl:col-span-3">
                            <h2 id="product-heading" class="sr-only">{{ __('Products') }}</h2>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 xl:gap-x-8">
                                @foreach($products as $product)
                                    <x-link :href="route('single-product', $product)" class="group">
                                        <x-products.thumbnail :product="$product" class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-[7/8]"/>
                                        <h3 class="mt-4 text-sm text-gray-700">{{ $product->name }}</h3>
                                        <x-products.price :product="$product" class="mt-1 text-lg font-medium text-gray-900"/>
                                    </x-link>
                                @endforeach
                            </div>
                            <div class="mt-2">
                                {{ $products->links() }}
                            </div>
                        </section>
                    @else
                        <p class="col-span-3 text-center text-gray-500">{{ __('No products found.') }}</p>
                    @endif
                </div>
            </div>
        </x-container>
    </div>
</div>
