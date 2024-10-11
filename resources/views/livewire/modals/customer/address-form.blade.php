<x-partials.modal header-classes="p-4 border-b border-gray-100 sm:px-6 sm:py-4"
    content-classes="relative p-4 flex-1 sm:max-h-[500px] sm:px-6 sm:px-5"
    footer-classes="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse" form-action="save">
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <div class="space-y-4 sm:pb-4">

        <div class="flex justify-between gap-2">

            <div class="space-y-2">
                <x-forms.label for="first_name" :value="__('First name')" :required="true" />
                <x-text-input wire:model="first_name" id="first_name" name="first_name" type="text"/>
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-forms.label for="last_name" :value="__('Last name')" :required="true" />
                <x-text-input wire:model="last_name" id="last_name" name="last_name" type="text"/>
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <div class="space-y-2">
            <x-forms.label for="street_address" :value="__('Street Address')"  :required="true"/>
            <x-text-input wire:model="street_address" id="street_address"  placeholder="Akwa Avenue 34" class="w-full"
                name="street_address" type="text" />
            <x-input-error :messages="$errors->get('street_address')" class="mt-2" />
        </div>


        <div class="space-y-2">
            <x-forms.label for="street_address_plus" :value="__('Apartment, suite, etc.')" />
            <x-text-input wire:model="street_address_plus" class="w-full" id="street_address_plus"
                name="street_address_plus" type="text"  />
            <x-input-error :messages="$errors->get('street_address_plus')" class="mt-2" />
        </div>


        <div class="flex justify-between gap-2">

            <div class="space-y-2">
                <x-forms.label for="city" :value="__('City')" :require="true" :required="true"/>
                <x-text-input wire:model="city" id="city" name="city" type="text" />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-forms.label for="postal_code" :value="__('Postal / Zip code')" :required="true" />
                <x-text-input wire:model="postal_code" id="postal_code" name="postal_code" type="text"/>
                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
            </div>

        </div>

        @if ($countries->isNotEmpty())
            <div class="space-y-2">
                <x-forms.label for="country_id" :value="__('Country')" :required="true" />
                <x-forms.select wire:model="country_id" id="country_id" class="w-full">
                    @foreach ($countries as $country)
                        <option value="{{ $countries->id }}">{{ $countries->name }}</option>
                    @endforeach
                </x-forms.select>
                <x-input-error :messages="$errors->get('country_id')" class="mt-2" />
            </div>
        @else
            <div class="space-y-2">
                <x-forms.label for="countryId" :value="__('Country')" />
                <x-text-input readonly value="No country found" class="w-full text-gray-500" type="text" />
            </div>
        @endif

        <div class="space-y-2">
            <x-forms.label for="phone_number" :value="__('Phone Number')" />
            <x-text-input wire:model="phone_number" class="w-full" id="phone_number" name="phone_number" type="text" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <div class="grid gap-y-2 sm:grid-cols-3 sm:gap-x-4 sm:items-start">
            <div class="flex items-center justify-between gap-x-3 ">
                <x-forms.label for="adress_type" :value="__('Address type')" />
            </div>

            <div class="grid auto-cols-fr gap-y-2 sm:col-span-2">
                <div  class="columns-[--cols-default] fi-fo-radio gap-4 flex flex-wrap">
                    <div>
                        <label class="flex gap-x-3">
                            <x-radio-input id="type-billing" name="type" value="billing" wire:model="type"/>
                            <div class="grid text-sm leading-6">
                                <x-forms.label for="billing_address" :value="__('Billing address')" />
                            </div>
                        </label>
                    </div>

                    <div>
                        <label class="flex gap-x-3">
                        <x-radio-input id="type-shipping" name="type" value="shipping" wire:model="type"/>
                            <div class="grid text-sm leading-6">
                                <x-forms.label for="shipping_address" :value="__('Shipping address')" />
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
</x-partials.modal>
