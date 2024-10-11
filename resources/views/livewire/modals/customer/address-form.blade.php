<x-modal header-classes="p-4 border-b border-gray-100 sm:px-6 sm:py-4"
    content-classes="relative p-4 flex-1 sm:max-h-[500px] sm:px-6 sm:px-5"
    footer-classes="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse" form-action="save">
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <div class="space-y-4 sm:pb-4">

        <div class="flex justify-between gap-2">

            <div class="space-y-2">
                <x-input-label for="firstName" :value="__('First name')" :required="true" />
                <x-text-input wire:model="firstName" id="firstName" name="firstName" type="text"/>
                <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-input-label for="lastName" :value="__('Last name')" :required="true" />
                <x-text-input wire:model="lastName" id="lastName" name="lastName" type="text"/>
                <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
            </div>
        </div>

        <div class="space-y-2">
            <x-input-label for="streetAddress" :value="__('Street Address')"  :required="true"/>
            <x-text-input wire:model="streetAddress" id="streetAddress"  placeholder="Akwa Avenue 34" class="w-full"
                name="streetAddress" type="text" />
            <x-input-error :messages="$errors->get('streetAddress')" class="mt-2" />
        </div>


        <div class="space-y-2">
            <x-input-label for="streetAddressPlus" :value="__('Apartment, suite, etc.')" />
            <x-text-input wire:model="streetAddressPlus" class="w-full" id="streetAddressPlus"
                name="streetAddressPlus" type="text"  />
            <x-input-error :messages="$errors->get('streetAddressPlus')" class="mt-2" />
        </div>


        <div class="flex justify-between gap-2">

            <div class="space-y-2">
                <x-input-label for="city" :value="__('City')" :require="true" :required="true"/>
                <x-text-input wire:model="city" id="city" name="city" type="text" />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-input-label for="postalCode" :value="__('Postal / Zip code*')" :required="true" />
                <x-text-input wire:model="postalCode" id="postalCode" name="postalCode" type="text"/>
                <x-input-error :messages="$errors->get('postalCode')" class="mt-2" />
            </div>

        </div>

        @if ($countries->isNotEmpty())
            <div class="space-y-2">
                <x-input-label for="countryId" :value="__('Country')" :required="true" />
                <x-forms.select wire:model="countryId" id="countryId" class="w-full">
                    @foreach ($countries as $country)
                        <option value="{{ $countries->id }}">{{ $countries->name }}</option>
                    @endforeach
                </x-forms.select>
                <x-input-error :messages="$errors->get('countryId')" class="mt-2" />
            </div>
        @else
            <div class="space-y-2">
                <x-input-label for="countryId" :value="__('Country')" />
                <x-text-input readonly value="No country found" class="w-full text-gray-500" type="text" />
            </div>
        @endif

        <div class="space-y-2">
            <x-input-label for="phoneNumber" :value="__('Phone Number')" />
            <x-text-input wire:model="phoneNumber" class="w-full" id="phoneNumber" name="phoneNumber" type="text" />
            <x-input-error :messages="$errors->get('phoneNumber')" class="mt-2" />
        </div>

        <div class="grid gap-y-2 sm:grid-cols-3 sm:gap-x-4 sm:items-start">
            <div class="flex items-center justify-between gap-x-3 ">
                <x-input-label for="adress_type" :value="__('Address type')" />
            </div>
            <div class="grid auto-cols-fr gap-y-2 sm:col-span-2">
                <div style="--cols-default: 1;" class="columns-[--cols-default] fi-fo-radio gap-4 flex flex-wrap">
                    <div class="">
                        <label class="flex gap-x-3">
                            <input type="radio"
                                class="mt-1 transition duration-75 bg-white border-none shadow-sm fi-radio-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                id="type-billing" name="data.type" value="billing" wire:loading.attr="disabled"
                                wire:model="type">

                            <div class="grid text-sm leading-6">
                                <x-input-label for="billing_address" :value="__('Billing address')" />
                            </div>
                        </label>
                    </div>
                    <div class="">
                        <label class="flex gap-x-3">
                            <input type="radio"
                                class="mt-1 transition duration-75 bg-white border-none shadow-sm fi-radio-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                id="type-shipping" name="data.type" value="shipping" wire:loading.attr="disabled"
                                wire:model="type">

                            <div class="grid text-sm leading-6">
                                <x-input-label for="billing_address" :value="__('Shipping address')" />
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>

    </div>

    <x-slot name="buttons">
        <x-buttons.primary type="submit" class="w-full px-4 py-3 text-sm sm:ml-3 sm:w-auto">
            <span class="absolute left-0 pl-2" wire:loading>
                <x-loading-dots class="bg-white" />
            </span>
            {{ __('shopper::forms.actions.save') }}
        </x-buttons.primary>
        <x-buttons.default type="button" wire:click="$dispatch('closeModal')"
            class="w-full px-4 py-2 mt-3 text-sm sm:mt-0 sm:w-auto">
            {{ __('shopper::forms.actions.cancel') }}
        </x-buttons.default>
    </x-slot>
</x-modal>
