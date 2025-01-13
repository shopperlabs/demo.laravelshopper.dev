<form class="mt-6" wire:submit="addToCart">
    @if ($product->variants->isNotEmpty())
        <fieldset>
            <legend class="text-md text-gray-500">
                Variants: <span class="font-bold text-sm text-gray-700">{{ $selectedVariant?->name }}</span>
            </legend>
            <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
                @foreach ($product->variants as $variant)
                    <x-link
                        :href="route('single-product', ['product' => $product , 'variant'=> $variant])"
                        @class([
                            'inline-flex items-center justify-center text-gray-500 font-medium px-3 py-2.5 rounded-md border border-gray-200',
                            'ring-2 ring-primary-600 ring-offset-2 hover:text-gray-900' => $selectedVariant && $selectedVariant->id === $variant->id,
                            'border bg-neutral-100 px-2 py-1 relative z-10 cursor-not-allowed overflow-hidden bg-neutral-100
                             text-neutral-500 ring-1 ring-neutral-300 before:absolute before:inset-x-0 before:-z-10 before:h-px
                             before:-rotate-45 before:bg-neutral-300 before:transition-transform' =>  $variant->stock < 1 || is_null($variant->getPrice())
                        ])
                    >
                        {{ $variant->name }}
                    </x-link>
                @endforeach
            </div>
        </fieldset>
    @endif

    <div class="flex items-center gap-2 mt-10">
        <x-buttons.primary
            type="submit"
            class="max-w-xs px-8 py-3 sm:w-full"
            :disabled="$product->isVariant() && ! $selectedVariant || $product->isVariant() && $this->selectedVariant && $this->selectedVariant->stock < 1 ||
            ! $product->isVariant() && $product->stock < 1"
        >
            {{ $product->isVariant() && ! $selectedVariant ? __('Choose any variant') : __('Add to cart') }}
        </x-buttons.primary>

        <x-buttons.primary type="button" class="px-4">
            <x-untitledui-heart class="size-6" aria-hidden="true" />
            <span class="sr-only">{{ __('Add to favorites') }}</span>
        </x-buttons.primary>
    </div>
</form>
