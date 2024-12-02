<div>
    <div class="relative overflow-hidden isolate">
        <x-container class="py-12 lg:py-20">
            <div class="max-w-3xl lg:max-w-none">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 font-heading">
                    {{ $category->name }}
                </h2>

                <div class="grid grid-cols-1 mt-6 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-x-8">
                    @forelse($products as $product)
                        <x-products.card :product="$product" />
                    @empty
                        <div class="col-span-3 ml-32 space-y-4">
                            <p class="text-gray-500">{{ __('This is an example of a category product. it does not contain any products.') }}</p>
                            @if($category->children->isNotEmpty())
                                <div class="flex flex-col">
                                    @foreach($category->children->filter(function($child) {
                                        return $child->is_enabled;
                                    }) as $child)
                                        <x-link  class="flex items-center font-heading text-primary-600 text-md hover:text-primary-800" :href="route('category.products',['category'=> $child->slug])">
                                            {{ $child->name }}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1 size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                            </svg>
                                        </x-link>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>
        </x-container>
    </div>
</div>
