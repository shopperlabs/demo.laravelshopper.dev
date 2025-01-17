@props([
    'product',
])

<div class="relative group">
    <x-products.thumbnail :product="$product" />

    <div class="flex justify-between mt-4">
        <div>
            <h3 class="text-sm font-medium text-gray-700">
                <x-link :href="route('single-product', $product)">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ $product->name }}
                </x-link>
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
