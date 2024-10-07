<div class="relative flow-root">
    <button
        wire:click="$dispatch('openPanel', { component: 'shopping-cart' })"
        type="button"
        class="group -m-2 flex items-center p-2"
    >
        <x-untitledui-shopping-bag-02
            class="size-6 text-gray-400 group-hover:text-gray-500"
            stroke-width="1.5"
            aria-hidden="true"
        />
        <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">
            {{ $cartTotalItems }}
        </span>
        <span class="sr-only">{{ __('items in cart, view cart') }}</span>
    </button>
</div>
