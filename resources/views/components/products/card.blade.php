@props([
    'product',
])

<div class="relative group">
    <x-products.thumbnail :product="$product" class='w-full h-56 lg:h-72 xl:h-80' />

    <h3 class="mt-4 text-sm text-gray-700">
        <x-link :href="route('single-product', ['slug' => $product->slug])">
            <span class="absolute inset-0"></span>
            {{ $product->name }}
        </x-link>
    </h3>
    @if ($product->brand)
        <p class="mt-1 text-sm text-gray-500">
            {{ $product->brand->name }}
        </p>
    @endif
    <x-products.price :product="$product" class="mt-1" />
</div>
