<div>
    @if ($address->exists)
        <flux:button size="sm" wire:click="openModal">
            {{ __('Edit') }}
        </flux:button>
    @else
        <flux:button type="button" wire:click="openModal" class="w-full sm:w-auto">
            {{ __('Add address') }}
        </flux:button>
    @endif

    <flux:modal wire:model="showModal" class="md:w-2xl">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $title }}</flux:heading>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label badge="required">{{ __('First name') }}</flux:label>
                        <flux:input wire:model="first_name" type="text" />
                        <flux:error name="first_name" />
                    </flux:field>

                    <flux:field>
                        <flux:label badge="required">{{ __('Last name') }}</flux:label>
                        <flux:input wire:model="last_name" type="text" />
                        <flux:error name="last_name" />
                    </flux:field>
                </div>

                <flux:field>
                    <flux:label badge="required">{{ __('Street Address') }}</flux:label>
                    <flux:input wire:model="street_address" placeholder="Akwa Avenue 34" type="text" />
                    <flux:error name="street_address" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Apartment, suite, etc.') }}</flux:label>
                    <flux:input wire:model="street_address_plus" type="text" />
                    <flux:error name="street_address_plus" />
                </flux:field>

                <div class="grid grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label badge="required">{{ __('City') }}</flux:label>
                        <flux:input wire:model="city" type="text" />
                        <flux:error name="city" />
                    </flux:field>

                    <flux:field>
                        <flux:label badge="required">{{ __('Postal / Zip code') }}</flux:label>
                        <flux:input wire:model="postal_code" type="text" />
                        <flux:error name="postal_code" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('State / Province') }}</flux:label>
                        <flux:input wire:model="state" type="text" placeholder="e.g. Littoral" />
                        <flux:error name="state" />
                    </flux:field>

                    <flux:field>
                        <flux:label badge="required">{{ __('Country') }}</flux:label>
                        <flux:select wire:model="country_id" placeholder="{{ __('Select a country') }}">
                            @foreach ($countries as $key => $country)
                                <option value="{{ $key }}">{{ $country }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="country_id" />
                    </flux:field>
                </div>


                <flux:field>
                    <flux:label>{{ __('Phone Number') }}</flux:label>
                    <flux:input wire:model="phone_number" type="text" />
                    <flux:error name="phone_number" />
                </flux:field>

                <flux:radio.group wire:model="type" label="{{ __('Address type') }}">
                    <flux:radio value="billing" label="{{ __('Billing address') }}" />
                    <flux:radio value="shipping" label="{{ __('Shipping address') }}" />
                </flux:radio.group>
            </div>

            <div class="flex gap-3 justify-end">
                <flux:button type="button" wire:click="$set('showModal', false)">
                    {{ __('shopper::forms.actions.cancel') }}
                </flux:button>
                <flux:button variant="primary" type="submit">
                    {{ __('shopper::forms.actions.save') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
