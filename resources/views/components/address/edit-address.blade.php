@props(['address'])

<div class="relative flex min-h-62.5 overflow-hidden justify-between border border-zinc-200 bg-white rounded-lg px-5 py-6">
    @if ($address->type === \Shopper\Core\Enum\AddressType::Billing)
        <div class="absolute top-2 right-2">
            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md gap-x-2 bg-primary-600 text-primary-100">
                <x-untitledui-credit-card class="size-4" stroke-width="1.5" aria-hidden="true" />
                {{ __('Billing') }}
            </span>
        </div>
    @endif

    <div class="flex flex-col justify-between  gap-4 flex-1">
        <div class="flex flex-col space-y-4">
            <h4 class="text-base font-medium text-left text-zinc-900 font-heading">
                {{ $address->first_name }} {{ $address->last_name }}
            </h4>
            <p class="flex flex-col text-sm text-left text-zinc-500">
                <span>
                    {{ $address->street_address }}
                    @if ($address->street_address_plus)
                        <span>, {{ $address->street_address_plus }}</span>
                    @endif
                </span>
                <span>
                    {{ $address->postal_code }}, {{ $address->city }}
                </span>
                <span>
                    {{ $address->country?->name }}
                </span>
            </p>
            <div class="space-y-2">
                @if ($address->isShippingDefault())
                    <flux:badge size="sm" icon="check">
                        {{ __('Default shipping address') }}
                    </flux:badge>
                @endif

                @if ($address->isBillingDefault())
                    <flux:badge size="sm" icon="check">
                        {{ __('Default billing address') }}
                    </flux:badge>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-2">
            <flux:button size="sm" variant="danger" wire:click="removeAddress({{ $address->id }})"
                wire:confirm="{{ __('Do you really want to delete this address ?') }}">
                <x-untitledui-trash-03 class="size-5" stroke-width="1.5" aria-hidden="true" />
                <span class="sr-only">{{ __('Delete') }}</span>
            </flux:button>
            <livewire:modals.customer.address-form :address-id="$address->id" :key="'address-form-'.$address->id" />

            <flux:dropdown>
                <flux:button size="sm" icon="ellipsis-horizontal" />

                <flux:menu>
                    @unless ($address->isShippingDefault())
                        <flux:menu.item wire:click="setDefaultShipping({{ $address->id }})" icon="truck">
                            {{ __('Set as default shipping') }}
                        </flux:menu.item>
                    @endunless

                    @unless ($address->isBillingDefault())
                        <flux:menu.item wire:click="setDefaultBilling({{ $address->id }})" icon="credit-card">
                            {{ __('Set as default billing') }}
                        </flux:menu.item>
                    @endunless
                </flux:menu>
            </flux:dropdown>
        </div>
    </div>
</div>
