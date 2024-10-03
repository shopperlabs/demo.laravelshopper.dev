<div class="h-8 bg-primary-800">
    <x-container class="flex items-center justify-between">
        <div class="flex items-center gap-x-6 text-white">
            <x-wire-link
                href="#"
                class="inline-flex h-8 items-center justify-center text-sm uppercase leading-5 tracking-wider hover:text-primary-200"
            >
                {{ __('Boutique') }}
            </x-wire-link>
            <x-wire-link
                href="#"
                class="inline-flex h-8 items-center justify-center text-sm uppercase leading-5 tracking-wider hover:text-primary-200"
            >
                {{ __('Studio') }}
            </x-wire-link>
        </div>
        <div class="hidden lg:block">
            <p class="text-sm font-medium text-white sm:px-6 lg:px-8">
                {{ __('Livraison gratuite à partir de :amount', ['amount' => shopper_money_format(config('livewire-starter-kit.free_shipping'))]) }}
            </p>
        </div>
    </x-container>
</div>
