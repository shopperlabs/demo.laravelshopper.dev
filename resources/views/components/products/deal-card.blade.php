@props(['product'])

<div class="group relative">
    <div class="relative h-56 w-full overflow-hidden rounded-lg bg-secondary-200 group-hover:opacity-75 lg:h-72 xl:h-80">
        <img src="{{ $product->getFirstMediaUrl(config('shopper.core.storage.collection_name')) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center">
        <span class="absolute bottom-4 left-0 px-3 py-1.5 text-xs font-medium bg-red-600 text-white">
            {{ __('Promo') }}
        </span>
    </div>
    <div class="mt-5">
        @if($product->brand)
            <p class="text-sm text-secondary-500">
                {{ $product->brand->name }}
            </p>
        @endif
        <h3 class="mt-1 font-medium text-secondary-900">
            <a href="#">
                <span class="absolute inset-0"></span>
                {{ $product->name }}
            </a>
        </h3>
        <div class="mt-1 text-sm text-secondary-500">
            <p class="font-semibold text-red-500">
                {{ $product->getPriceAmount()->formatted }}
            </p>
            <p>
                {{ __('Originally :') }}
                <span class="line-through">
                    {{ $product->getOldPriceAmount()->formatted }}
                </span>
                <x-discount-badge
                    :discount="$product->discount_percentage"
                    class="ml-2"
                />
            </p>
        </div>
    </div>
</div>
