<div>
    <form class="mt-6" wire:submit="addToCart">

        <div class="hidden">
            <h3 class="text-sm text-gray-600">{{ __('Color') }}</h3>

            <fieldset aria-label="Choose a color" class="mt-2">
                <div class="flex items-center space-x-3">
                    <x-products.color :product="$product" />
                </div>
            </fieldset>
        </div>

        @if ($product->variants->isnotEmpty())
            <div>
                <fieldset>
                    <legend class="text-sm text-gray-600 mb-2">Variant : <span class="font-bold text-sm"> {{  $currentVariant->name }}</span></legend>
                        <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                            @foreach ($product->variants as $variant)
                                <x-buttons.default :href="route('single-product', [ 'slug' => $product->slug , 'variant'=> $variant->slug ])"
                                    class="flex cursor-pointer items-center justify-center {{ (isset($currentVariant) &&  $currentVariant->id === $variant->id ) ? 'border-2 border-primary-600' : '' }} px-3 py-3 text-sm font-medium uppercase sm:flex-1">
                                    <span>{{ $variant->name }}</span>
                                </x-buttons.default>
                            @endforeach
                        </div>
                </fieldset>
             </div>
        @endif
        <div class="flex items-center gap-2 mt-10">
            <x-buttons.primary type="submit" class="max-w-xs px-8 py-3 sm:w-full">
                {{ __('Add to cart') }}
            </x-buttons.primary>

            <x-buttons.primary type="button" class="px-4">
                <x-untitledui-heart class="size-6" aria-hidden="true" />
                <span class="sr-only">{{ __('Add to favorites') }}</span>
            </x-buttons.primary>
        </div>
    </form>
</div>
