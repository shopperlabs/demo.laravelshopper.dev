@props(['address'])

<div class="relative flex min-h-[250px] overflow-hidden justify-between border border-gray-400 bg-white px-5 py-6">
    @if($address->type === \Shopper\Core\Enum\AddressType::Billing)
        <div class="absolute top-0 right-0">
            <span class="inline-flex items-center gap-x-2 bg-primary-900 px-2 py-1 text-xs font-medium text-primary-100">
                <x-untitledui-tag class="h-4 w-4" stroke-width="1.5" aria-hidden="true" />
                {{ __('Facturation') }}
            </span>
        </div>
    @endif
    <div class="flex-1 flex flex-col justify-between">
        <div class="flex flex-col space-y-4">
            <h4 class="text-left text-base font-heading font-medium text-gray-900">
                {{ $address->first_name }} {{ $address->last_name }}
            </h4>
            <p class="flex flex-col text-sm text-left text-gray-500">
            <span>
                {{ $address->street_address }}
                @if($address->street_address_plus)
                    <span>, {{ $address->street_address_plus }}</span>
                @endif
            </span>
                <span>
                {{ $address->postal_code }}, {{ $address->city }}
            </span>
                <span>
                {{ $address->country->name }}
            </span>
            </p>
            <div class="space-y-2">
                @if($address->isShippingDefault())
                    <div class="flex items-center gap-2 text-sm">
                        <x-heroicon-o-check class="h-5 w-5 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                        <span class="text-gray-600">
                        {{ __('Adresse de livraison par défaut') }}
                    </span>
                    </div>
                @endif
                @if($address->isBillingDefault())
                    <div class="flex items-center gap-2 text-sm">
                        <x-heroicon-o-check class="h-5 w-5 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                        <span class="text-gray-600">
                        {{ __('Adresse de facturation par défaut') }}
                    </span>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-buttons.default
                class="text-sm px-2.5 pb-1 pt-2"
                wire:click="removeAddress({{ $address->id }})"
                wire:confirm="{{ __('Voulez-vous vraiment supprimé cette adresse ?') }}"
            >
                <x-untitledui-trash-03 class="h-5 w-5" stroke-width="1.5" aria-hidden="true" />
                <span class="sr-only">{{ __('Supprimer') }}</span>
            </x-buttons.default>
            <x-buttons.default
                class="text-sm px-3 pb-1 pt-2"
                wire:click="$dispatch('openModal', { component: 'modals.customer.address-form', arguments: { addressId: {{ $address->id }} }})"
            >
                <span class="inline-flex items-center gap-2">
                    <x-untitledui-pencil-02 class="h-5 w-5 text-brand group-hover:text-brand-700" stroke-width="1.5" aria-hidden="true" />
                    <span>{{ __('Éditer') }}</span>
                </span>
            </x-buttons.default>
        </div>
    </div>
</div>
