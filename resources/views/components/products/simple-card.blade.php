@props([
    'product',
])

<div class="group relative">
    <x-products.thumbnail :product="$product" />

    <div class="mt-4 flex justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">
                <x-wire-link :href="route('single-product', ['slug' => $product->slug])">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ $product->name }}
                </x-wire-link>
            </h3>
            @if ($product->brand_id)
                <p class="mt-1 text-sm text-gray-500">
                    {{ $product->brand->name }}
                </p>
            @endif
        </div>
        <x-products.price :product="$product" />
    </div>
</div>
