<div class="bg-white">
    <div class=" pb-16 sm:pb-24">
        <x-container class="max-w-2xl">

            <main class="mx-auto  px-4 lg:max-w-7xl lg:px-8">
                <div class="border-b border-gray-200 pb-4 pt-8 mb-2">
                    <h1 class="text-4xl  font-bold tracking-tight text-gray-900">{{ __('Shop') }}</h1>
                    <p class="mt-4 text-base text-gray-500">{{  __('Discover a wide range of products for a new and enriching experience!') }}</p>
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

                        <div class="hidden lg:block">
                            <form class="space-y-10 divide-y divide-gray-200">
                                @foreach($atributes as $attribute)
                                    <div>
                                        <fieldset>
                                            <legend class="block text-sm font-medium text-gray-900">{{$attribute->name}}</legend>
                                            @if ($attribute->values->isNotEmpty())
                                                <div class="space-y-3 pt-6">
                                                    @foreach ($attribute->values as $index => $value)
                                                        <div class="flex items-center">
                                                            <input id="{{ $attribute->slug }}-{{ $index }}" wire:model.live="selectedAttributes"
                                                                   name="{{ $attribute->slug }}[]" value="{{ $value->id }}" type="checkbox"
                                                                   class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                            <label for="{{ $attribute->slug }}-{{ $index }}" class="ml-3 text-sm text-gray-600">{{ $value->value }}</label>

                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </fieldset>
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    </aside>
                    @if(!is_null($products) && $products->isNotEmpty() )
                        <section aria-labelledby="product-heading" class="mt-6 lg:col-span-2 lg:mt-0 xl:col-span-3">
                            <h2 id="product-heading" class="sr-only">{{ __('Products') }}</h2>

                            <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:gap-x-8 xl:grid-cols-3">
                                @foreach($products as $product)
                                    <div class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
                                        <img src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}" alt="{{ $product->name }} thumbnail" class="aspect-[3/4] bg-gray-200 object-cover group-hover:opacity-75 sm:h-96">
                                        <div class="flex flex-1 flex-col space-y-2 p-4">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                <x-link :href="route('single-product', ['slug' => $product->slug])">
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
                            <div class="mt-2">
                            {{ $products->links() }}
                            </div>
                        </section>
                    @else
                        <p class="col-span-3 text-center text-gray-500">{{ __('No products found.') }}</p>
                    @endif
                </div>
            </main>

        </x-container>
    </div>
</div>
