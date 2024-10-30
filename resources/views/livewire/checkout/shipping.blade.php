<div class="flex flex-col justify-between space-y-10">
    @include('components.checkout-steps')

    <div class="text-sm leading-5 text-gray-500">
        <x-buttons.default
            type="button"
            wire:click="$dispatch('openModal', { component: 'modals.customer.address-form' })"
            class="w-full px-8 py-2 text-sm sm:w-auto"
        >
            {{ __('Add an address') }}
        </x-buttons.default>
    </div>

    @if($addresses->isNotEmpty())
        <form wire:submit="save" class="flex-1 space-y-3">
            @error('shippingAddressId')
                <div class="p-4 border-l-4 border-danger-400 bg-danger-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-danger-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-danger-700">
                                {{ __($message) }}
                            </p>
                        </div>
                    </div>
                </div>
            @enderror

            <div class="max-w-lg mx-auto lg:max-w-none">
                <div class="space-y-5">
                    <div>
                        <div>
                            <h4 class="font-medium leading-6 text-gray-900 font-heading">
                                {{ __('Delivery addresses') }}
                            </h4>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ __('Select a delivery address.') }}
                            </p>
                        </div>

                        @if($addresses->has('shipping') && $addresses->get('shipping')->isNotEmpty())
                            <fieldset aria-label="{{ __('Delivery addresses') }}" class="mt-3 divide-y divide-gray-200">
                                @foreach($addresses->get('shipping') as $shippingAddress)
                                    <label
                                        for="shipping-address-{{ $shippingAddress->id }}"
                                        class="relative flex items-start gap-3 py-3 cursor-pointer group focus:outline-none"
                                    >
                                        <input
                                            type="radio"
                                            wire:model="shippingAddressId"
                                            id="shipping-address-{{ $shippingAddress->id }}"
                                            name="shipping"
                                            value="{{ $shippingAddress->id }}"
                                            class="mt-0.5 h-4 w-4 shrink-0 cursor-pointer border-gray-300 text-primary focus:ring-primary-600 active:ring-2 active:ring-offset-2"
                                        >
                                        <span class="flex flex-col space-y-0.5 text-sm text-gray-500">
                                        <span class="font-medium text-gray-900">{{ $shippingAddress->full_name }}</span>
                                        <span>
                                            {{ $shippingAddress->street_address }}, {{ $shippingAddress->city }} {{ $shippingAddress->postal_code }}, {{ $shippingAddress->country->name }}
                                        </span>
                                        <span>
                                            {{ __('Phone number') }} : {{ $shippingAddress->phone_number ?? '' }}
                                        </span>
                                    </span>
                                    </label>
                                @endforeach
                            </fieldset>
                        @endif
                    </div>
                    <div class="space-y-5">
                        <div>
                            <h4 class="font-medium leading-6 text-gray-900 font-heading">
                                {{ __('Billing address') }}
                            </h4>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ __('Fill in a billing address.') }}
                            </p>
                        </div>

                        <div>
                            <label for="same_as_shipping" class="inline-flex items-center">
                                <input wire:model.live="sameAsShipping" id="same_as_shipping" type="checkbox" class="border-gray-300 text-brand focus:ring-brand" name="same_as_shipping">
                                <span class="text-sm text-gray-600 ms-2">{{ __("Same to delivery address") }}</span>
                            </label>
                        </div>

                        @error('billingAddressId')
                            <div class="p-4 border-l-4 border-danger-400 bg-danger-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-danger-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-danger-700">
                                            {{ __($message) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @enderror

                        @if(! $sameAsShipping)
                            @if($addresses->has('billing') && $addresses->get('billing')->isNotEmpty())
                                <fieldset aria-label="{{ __('Billing addresses') }}" class="divide-y divide-gray-200">
                                    @foreach($addresses->get('billing') as $billingAddress)
                                        <label
                                            for="billing-address-{{ $billingAddress->id }}"
                                            class="relative flex items-start gap-3 py-3 cursor-pointer group focus:outline-none"
                                        >
                                            <input
                                                type="radio"
                                                wire:model="billingAddressId"
                                                id="billing-address-{{ $billingAddress->id }}"
                                                name="billing"
                                                value="{{ $billingAddress->id }}"
                                                class="mt-0.5 h-4 w-4 shrink-0 cursor-pointer border-gray-300 text-primary focus:ring-primary-600 active:ring-2 active:ring-offset-2"
                                            >
                                            <span class="flex flex-col space-y-0.5 text-sm text-gray-500">
                                                <span class="font-medium text-gray-900">{{ $billingAddress->full_name }}</span>
                                                <span>
                                                    {{ $billingAddress->street_address }}, {{ $billingAddress->city }} {{ $billingAddress->postal_code }}, {{ $billingAddress->country->name }}
                                                </span>
                                                <span>
                                                    {{ __('Phone number') }} : {{ $billingAddress->phone_number ?? '' }}
                                                </span>
                                            </span>
                                        </label>
                                    @endforeach
                                </fieldset>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="pt-6 mt-10 border-t border-gray-200 sm:flex sm:items-center sm:justify-end">
                    <x-buttons.primary type="submit" class="w-full px-8 py-2 text-sm sm:w-auto">
                        <span class="absolute left-0 pl-2" wire:loading>
                            <x-loading-dots class="bg-white" />
                        </span>

                        {{ __('Continue') }}
                    </x-buttons.primary>
                </div>
            </div>
        </form>
    @else
        <div class="p-4 text-sm font-medium leading-6 text-gray-700 bg-gray-50">
            {{ __('You don\'t have a corresponding address.') }}
        </div>
    @endif
</div>
