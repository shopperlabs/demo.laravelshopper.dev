<div>

    <form class="mt-6">
        <!-- Colors -->
        <div>
            <h3 class="text-sm text-gray-600">Color</h3>

            <fieldset aria-label="Choose a color" class="mt-2">
                <div class="flex items-center space-x-3">
                    <!-- Active and Checked: "ring ring-offset-1" -->
                    <x-products.color :product="$product" />
                </div>
            </fieldset>
        </div>

        <div class="flex mt-10">
            <x-buttons.primary type="submit"
                class="flex items-center justify-center flex-1 max-w-xs px-8 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 sm:w-full">
                {{ __('Add to cart') }}
            </x-buttons.primary>

            <x-buttons.primary type="button"
                class="flex items-center justify-center px-3 py-3 ml-4 text-gray-400 rounded-md hover:bg-gray-100 hover:text-gray-500">
                <svg class="flex-shrink-0 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
                <span class="sr-only">{{ __('Add to favorites') }}</span>
            </x-buttons.primary>

        </div>
    </form>
</div>
