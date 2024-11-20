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
                        <p class="col-span-3 text-center text-gray-500">{{ __('This is an example of a category product. it does not contain any products.') }}</p>
                    @endforelse
                </div>
            </div>
        </x-container>
    </div>
</div>