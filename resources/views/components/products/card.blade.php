@blaze

@props([
    'product',
])

<div class="relative group">
    <x-products.thumbnail
        :$product
        class='w-full rounded-lg lg:h-72 xl:h-80'
    />

    <h3 class="mt-4 text-sm text-zinc-700 group-hover:text-zinc-900">
        <x-link :href="route('single-product', $product)">
            <span class="absolute inset-0"></span>
            {{ $product->name }}
        </x-link>
    </h3>

    @if ($product->brand_id)
        <p class="mt-1 text-sm text-zinc-500">
            {{ $product->brand->name }}
        </p>
    @endif

    @if(! $product->isVariant() && $product->prices->isNotEmpty())
        <x-products.price :$product class="mt-1" />
    @endif
</div>
