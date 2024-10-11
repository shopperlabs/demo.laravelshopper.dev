<div class="space-y-10">
    <x-page-heading
        :title="__('My addresses')"
        :description="__('View and update your delivery and billing addresses here.')"
    />

    <div class="space-y-8">
        <x-buttons.default
            type="button"
            wire:click="$dispatch('openModal', { component: 'modals.customer.address-form' })"
            class="w-full px-8 py-2 text-sm sm:w-auto"
        >
            {{ __('Add an address') }}
        </x-buttons.default>

        @if($addresses->isNotEmpty())
            <div class="sm:grid sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                @foreach($addresses as $address)
                    <x-address.edit-address :address="$address" />
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500">
                {{ __("You have not yet added any addresses to your space.") }}
            </p>
        @endif
    </div>
</div>
