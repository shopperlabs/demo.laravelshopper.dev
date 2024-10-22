@props(['product'])

<div class="relative group">
    <x-products.card-thumbnail :product="$product" />

    <h3 class="mt-4 text-sm text-gray-700">
        <x-link :href="route('single-product', ['slug' => $product->slug])">
            <span class="absolute inset-0"></span>
            {{ $product->name }}
        </x-link>
    </h3>
    @if ($product->brand_id)
        <p class="mt-1 text-sm text-gray-500">
            {{ $product->brand->name }}
        </p>
    @endif
    <p class="mt-1 text-sm font-medium text-gray-900"> {{ $product->getPriceAmount()?->formatted }}</p>
</div>
