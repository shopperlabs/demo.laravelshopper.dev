<x-container class="py-10 sm:py-14 lg:py-16">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="flex items-center">
            <x-untitledui-truck class="h-8 w-8 text-black" aria-hidden="true" stroke-width="1.5" />
            <div class="ml-4">
                <h4 class="font-heading font-medium text-gray-900">{{ __('Livraison gratuite') }}</h4>
                <p class="text-sm leading-5 text-gray-500">
                    {{ __('A partir de :amount', ['amount' => shopper_money_format(config('livewire-starter-kit.free_shipping'))]) }}
                </p>
            </div>
        </div>
        <div class="flex items-center">
            <x-untitledui-face-smile class="h-8 w-8 text-black" aria-hidden="true" stroke-width="1.5" />
            <div class="ml-4">
                <h4 class="font-heading font-medium text-gray-900">{{ __('24/7 support client') }}</h4>
                <p class="text-sm leading-5 text-gray-500">{{ __('Assistance clientèle amicale 24/7') }}</p>
            </div>
        </div>
        <div class="flex items-center">
            <x-heroicon-o-shield-check class="h-8 w-8 text-black" aria-hidden="true" stroke-width="1.5" />
            <div class="ml-4">
                <h4 class="font-heading font-medium text-gray-900">{{ __('Paiement sécurisé') }}</h4>
                <p class="text-sm leading-5 text-gray-500">{{ __('Sur toutes les commandes') }}</p>
            </div>
        </div>
        <div class="flex items-center">
            <x-heroicon-o-tag class="h-8 w-8 text-black" aria-hidden="true" stroke-width="1.5" />
            <div class="ml-4">
                <h4 class="font-heading font-medium text-gray-900">{{ __('Plusieurs styles disponibles') }}</h4>
                <p class="text-sm leading-5 text-gray-500">{{ __('Nous avons tout ce qu\'il faut') }}</p>
            </div>
        </div>
    </div>
</x-container>
