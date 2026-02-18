<div class="pb-16 sm:pb-24">
    <div class="py-3 bg-white/80 border-b border-zinc-200">
        <x-container>
            {{ Breadcrumbs::render('store') }}
        </x-container>
    </div>
    <x-container class="pb-24 pt-10">
        <div>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900">{{ __('Shop') }}</h1>
            <p class="mt-4 text-base text-zinc-500">
                {{  __('Discover a wide range of products for a new and enriching experience!') }}
            </p>
        </div>
        <div class="mt-6 lg:grid lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-4 lg:mt-10">
            <aside>
                <h2 class="sr-only">Filters</h2>
                <!-- Mobile filter dialog toggle, controls the 'mobileFilterDialogOpen' state. -->
                <button type="button" class="inline-flex items-center lg:hidden">
                    <span class="text-sm font-medium text-zinc-700">Filters</span>
                    <svg class="ml-1 size-5 shrink-0 text-zinc-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                </button>

                <div class="hidden w-72 lg:block">
                    <div class="divide-y divide-zinc-200">
                        @foreach ($this->options as $attribute)
                            @if(\Illuminate\Support\Facades\View::exists('components.attributes.'.$attribute->slug))
                                <x-dynamic-component :component="'attributes.'.$attribute->slug" :$attribute />
                            @else
                                <div wire:key="{{ $attribute->id }}" class="py-6">
                                    <p class="block text-sm font-medium text-zinc-900">{{ $attribute->name }}</p>
                                    @if ($attribute->values->isNotEmpty())
                                        <div x-data="{ expanded: false }">
                                            <flux:checkbox.group wire:model.live.debounce.350ms="selectedAttributes" class="pt-6 space-y-1.5">
                                                @foreach ($attribute->values as $index => $value)
                                                    <div wire:key="{{ $attribute->slug }}-{{ $value->key }}" x-show="expanded || {{ $index }} < 6">
                                                        <flux:checkbox
                                                            :value="$value->id"
                                                            :label="$value->value"
                                                        />
                                                    </div>
                                                @endforeach
                                            </flux:checkbox.group>

                                            @if ($attribute->values->count() > 6)
                                                <button
                                                    type="button"
                                                    x-on:click="expanded = !expanded"
                                                    class="mt-3 text-sm font-medium text-primary-600 hover:text-primary-700"
                                                >
                                                    <span x-text="expanded ? '{{ __('See less') }}' : '{{ __('See more') }}'"></span>
                                                </button>
                                            @endif
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

                    <div wire:loading.class="opacity-50 pointer-events-none" class="grid grid-cols-1 gap-x-6 gap-y-10 transition-opacity sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                        @foreach ($products as $product)
                            <x-products.catalog-card :$product />
                        @endforeach
                    </div>
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                </section>
            @else
                <p class="col-span-3 text-center text-zinc-500">{{ __('No products found.') }}</p>
            @endif
        </div>
    </x-container>
</div>
