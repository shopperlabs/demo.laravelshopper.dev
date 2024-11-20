@props([
    'product',
])
<div>
    <div class="relative">
        <div class="relative w-full overflow-hidden rounded-lg h-72">
            <img
                src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.thumbnail_collection')) }}"
                alt="{{ $product->name }} thumbnail"
                class="object-cover object-center w-full h-full"
            />
        </div>
        <div class="relative mt-4">
            <x-link :href="route('single-product', ['slug' => $product->slug])">
                <span class="absolute inset-0"></span>
                {{ $product->name }}
            </x-link>
        </div>
        <div class="absolute inset-x-0 top-0 flex items-end justify-end p-4 overflow-hidden rounded-lg h-72">
            <div aria-hidden="true" class="absolute inset-x-0 bottom-0 opacity-50 h-36 bg-gradient-to-t from-black">
            </div>
            <x-products.price :product="$product" class="relative text-lg font-semibold text-white" />
        </div>
    </div>
    <div class="mt-6">
        <x-buttons.primary
            type="button"
            wire:click="addToCart({{ $product->id }})"
            class="relative flex items-center justify-center px-8 py-2 text-sm font-medium bg-gray-100 border border-transparent rounded-md hover:bg-gray-200"
        >
            {{ __('Add to cart')}}
            <span class="sr-only">{{ $product->name }}</span>
        </x-buttons.primary>
    </div>
</div>
