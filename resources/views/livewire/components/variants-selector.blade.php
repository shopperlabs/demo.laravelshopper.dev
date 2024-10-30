<div>
    <form class="mt-6" wire:submit="addToCart">
        <div class="hidden">
            <h3 class="text-sm text-gray-600">{{ __('Color') }}</h3>

            <fieldset aria-label="Choose a color" class="mt-2">
                <div class="flex items-center space-x-3">
                    <!-- Active and Checked: "ring ring-offset-1" -->
                    <x-products.color :product="$product" />
                </div>
            </fieldset>
        </div>
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
