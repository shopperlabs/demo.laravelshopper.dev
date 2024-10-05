<div class="flex h-full flex-col divide-y divide-gray-200">
    <div class="h-0 flex-1 overflow-y-auto py-6">
        <header class="px-4 sm:px-6">
            <div class="flex items-start justify-between">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Mon panier') }}
                </h2>
                <div class="ml-3 flex h-7 items-center">
                    <button
                        type="button"
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                        wire:click="$dispatch('closePanel')"
                    >
                        <span class="sr-only">Close panel</span>
                        <x-untitledui-x class="size-6" stroke-width="1.5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </header>
        <div class="mt-8 flex-1 px-4 sm:px-6">
            <div class="space-y-5 text-center">
                <div class="flex shrink-0 items-center justify-center">
                    <x-icons.empty-cart class="h-40 w-auto" aria-hidden="true" />
                </div>
                <div class="text-center">
                    <h1 class="font-heading text-2xl font-medium text-gray-900">
                        {{ __('😱 Oups ! Votre panier est vide') }}
                    </h1>
                    <p class="mt-2 leading-6 text-gray-500">
                        {{ __('Consulter notre catalogue de produits pour trouver votre perle rare 🤩.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="space-y-4 p-4 sm:p-6">
        <div class="text-sm text-gray-500">
            <div class="mb-3 flex items-center justify-between border-b border-gray-200 pb-1">
                <p>{{ __('Taxes') }}</p>
                <p class="text-right text-base text-black">
                    {{ shopper_money_format(0) }}
                </p>
            </div>
            <div class="mb-3 flex items-center justify-between border-b border-gray-200 pb-1 pt-1">
                <p>{{ __('Livraison') }}</p>
                <p class="text-right">{{ __('Calculé au moment du paiement') }}</p>
            </div>
            <div class="mb-3 flex items-center justify-between border-b border-gray-200 pb-1 pt-1">
                <p>{{ __('Sous total') }}</p>
                <p class="text-right text-base text-black">
                    {{ shopper_money_format(0) }}
                </p>
            </div>
        </div>
        <x-buttons.primary :link="route('checkout')" class="w-full px-8 py-3 text-base">
            {{ __('Procéder au paiement') }}
        </x-buttons.primary>
    </div>
</div>
