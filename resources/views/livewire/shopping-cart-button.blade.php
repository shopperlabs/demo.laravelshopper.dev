<div class="relative flow-root">
    <button wire:click="$dispatch('openPanel', { component: 'shopping-cart' })" type="button"
        class="flex items-center p-2 -m-2 group">
        <x-untitledui-shopping-bag-02 class="text-zinc-400 size-6 group-hover:text-zinc-500" stroke-width="1.5"
            aria-hidden="true" />
        <span class="ml-2 text-sm font-medium text-zinc-700 group-hover:text-zinc-800">
            {{ $cartTotalItems }}
        </span>
        <span class="sr-only">{{ __('items in cart, view cart') }}</span>
    </button>
</div>
