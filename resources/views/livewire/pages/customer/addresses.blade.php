<div class="space-y-10">
    <x-page-heading
        :title="__('Mes adresses')"
        :description="__('Consultez et mettez à jour vos adresses de livraison et facturation ici.')"
    />

    <div class="space-y-8">
        <x-buttons.default
            type="button"
            wire:click="$dispatch('openModal', { component: 'modals.customer.address-form' })"
            class="w-full px-8 py-2 text-sm sm:w-auto"
        >
            {{ __('Ajouter une adresse') }}
        </x-buttons.default>

        @if($addresses->isNotEmpty())
            <div class="sm:grid sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                @foreach($addresses as $address)
                    <x-address.edit-address :address="$address" />
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500">
                {{ __("Vous n'avez encore ajouter aucune adresse dans votre espace.") }}
            </p>
        @endif
    </div>
</div>
