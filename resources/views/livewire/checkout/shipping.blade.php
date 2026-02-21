@php
    $formatAddress = function ($address) {
        $desc = $address->street_address . ', ' . $address->city . ' ' . $address->postal_code . ', ' . $address->country->name;
        if ($address->phone_number) {
            $desc .= ' — ' . __('Phone number') . ' : ' . $address->phone_number;
        }
        return $desc;
    };
@endphp

<div class="flex flex-col justify-between space-y-10">
    @include('components.checkout-steps')

    <div class="text-sm leading-5 text-zinc-500">
        <livewire:modals.customer.address-form :key="'address-form-checkout'" />
    </div>

    @if ($addresses->isNotEmpty())
        <form wire:submit="save" class="flex-1 space-y-3">
            <flux:error name="shippingAddressId" />

            <div class="max-w-lg mx-auto lg:max-w-none">
                <div class="space-y-5">
                    <div>
                        <flux:heading size="lg">{{ __('Delivery addresses') }}</flux:heading>
                        <flux:subheading>{{ __('Select a delivery address.') }}</flux:subheading>

                        @if ($addresses->has('shipping') && $addresses->get('shipping')->isNotEmpty())
                            <flux:radio.group wire:model="shippingAddressId" class="mt-5">
                                @foreach ($addresses->get('shipping') as $shippingAddress)
                                    <flux:radio
                                        value="{{ $shippingAddress->id }}"
                                        :label="$shippingAddress->full_name"
                                        :description="$formatAddress($shippingAddress)"
                                    />
                                @endforeach
                            </flux:radio.group>
                        @endif
                    </div>

                    <div class="mt-10 space-y-5">
                        <div>
                            <flux:heading size="lg">{{ __('Billing address') }}</flux:heading>
                            <flux:subheading>{{ __('Fill in a billing address.') }}</flux:subheading>
                        </div>

                        <flux:checkbox wire:model.live="sameAsShipping" label="{{ __('Same to delivery address') }}" />

                        <flux:error name="billingAddressId" />

                        @if(! $sameAsShipping)
                            @if ($addresses->has('billing') && $addresses->get('billing')->isNotEmpty())
                                <flux:radio.group wire:model="billingAddressId">
                                    @foreach ($addresses->get('billing') as $billingAddress)
                                        <flux:radio
                                            value="{{ $billingAddress->id }}"
                                            :label="$billingAddress->full_name"
                                            :description="$formatAddress($billingAddress)"
                                        />
                                    @endforeach
                                </flux:radio.group>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="pt-6 mt-10 border-t border-zinc-200 flex items-center justify-between">
                    <x-link :href="route('store')" class="text-sm text-primary-600 hover:text-primary-700">
                        <span>&larr;</span> {{ __('Return to cart') }}
                    </x-link>
                    <flux:button variant="primary" type="submit">
                        {{ __('Continue to shipping') }}
                    </flux:button>
                </div>
            </div>
        </form>
    @else
        <div class="p-4 text-sm font-medium leading-6 text-zinc-700 bg-zinc-50 rounded-lg">
            {{ __('You don\'t have a corresponding address.') }}
        </div>
        <div class="pt-6 border-t border-zinc-200">
            <x-link :href="route('store')" class="text-sm text-primary-600 hover:text-primary-700">
                <span>&larr;</span> {{ __('Return to cart') }}
            </x-link>
        </div>
    @endif
</div>
