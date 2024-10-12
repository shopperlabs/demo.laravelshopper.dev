@props(['address'])

<div class="relative flex min-h-[250px] overflow-hidden justify-between border border-gray-200 bg-white rounded-lg px-5 py-6">
    @if ($address->type === \Shopper\Core\Enum\AddressType::Billing)
        <div class="absolute top-2 right-2">
            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium gap-x-2 bg-primary-600 text-primary-100">
                <x-untitledui-tag class="size-4" stroke-width="1.5" aria-hidden="true" />
                {{ __('Billing') }}
            </span>
        </div>
    @endif

    <div class="flex flex-col justify-between flex-1">
        <div class="flex flex-col space-y-4">
            <h4 class="text-base font-medium text-left text-gray-900 font-heading">
                {{ $address->first_name }} {{ $address->last_name }}
            </h4>
            <p class="flex flex-col text-sm text-left text-gray-500">
                <span>
                    {{ $address->street_address }}
                    @if ($address->street_address_plus)
                        <span>, {{ $address?->street_address_plus }}</span>
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
                @if ($address->isShippingDefault())
                    <div class="flex items-center gap-2 text-sm">
                        <x-heroicon-o-check class="size-5 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                        <span class="text-gray-600">
                            {{ __('Default shipping address') }}
                        </span>
                    </div>
                @endif
                @if ($address->isBillingDefault())
                    <div class="flex items-center gap-2 text-sm">
                        <x-heroicon-o-check class="size-5 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                        <span class="text-gray-600">
                            {{ __('Default billing address') }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-buttons.default class="text-sm px-2.5 pb-1 pt-2" wire:click="removeAddress({{ $address->id }})"
                wire:confirm="{{ __('Do you really want to delete this address ?') }}">
                <x-untitledui-trash-03 class="w-5 h-5" stroke-width="1.5" aria-hidden="true" />
                <span class="sr-only">{{ __('Delete') }}</span>
            </x-buttons.default>
            <x-buttons.default class="px-3 pt-2 pb-1 text-sm"
                wire:click="$dispatch('openModal', { component: 'modals.customer.address-form', arguments: { addressId: {{ $address->id }} }})">
                <span class="inline-flex items-center gap-2">
                    <x-untitledui-pencil-02 class="w-5 h-5 text-brand group-hover:text-brand-700" stroke-width="1.5"
                        aria-hidden="true" />
                    <span>{{ __('Edit') }}</span>
                </span>
            </x-buttons.default>
        </div>
    </div>
</div>
