<?php

declare(strict_types=1);

use App\Livewire\Modals\Customer\AddressForm;
use App\Livewire\Pages\Customer\Addresses;
use App\Models\User;
use Livewire\Livewire;
use Shopper\Core\Enum\AddressType;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\Address;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->countries = Country::factory()
        ->count(3)
        ->create();

    $this->actingAs($this->user);
});

describe(Addresses::class, function (): void {
    it('user can create address', function (): void {
        Livewire::actingAs($this->user)
            ->test(AddressForm::class)
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('street_address', 'Ndokoti')
            ->set('street_address_plus', 'Adress street plus')
            ->set('type', AddressType::Billing)
            ->set('country_id', $this->countries->first()->id)
            ->set('postal_code', '33790')
            ->set('city', 'Douala')
            ->set('phone_number', '99007788')
            ->call('save')
            ->assertDispatched('addresses-updated');

        expect(Address::query()->count())
            ->toBe(1);
    });

    it('user can update address', function (): void {
        /** @var Address $address */
        $address = Address::factory([
            'first_name' => 'John',
            'type' => AddressType::Billing,
            'user_id' => $this->user->id,
            'country_id' => $this->countries->first()->id,
        ])->create();

        Livewire::test(AddressForm::class, ['addressId' => $address->id])
            ->set('first_name', 'Jane')
            ->set('last_name', $address->last_name)
            ->set('street_address', $address->street_address)
            ->set('street_address_plus', $address->street_address_plus)
            ->set('type', $address->type)
            ->set('country_id', $address->country_id)
            ->set('postal_code', $address->postal_code)
            ->set('city', $address->city)
            ->set('phone_number', $address->phone_number)
            ->call('save')
            ->assertDispatched('addresses-updated');

        /** @var Address $updatedAddress */
        $updatedAddress = Address::query()->findOrFail($address->id);

        expect($updatedAddress->first_name)
            ->toBe('Jane');
    });

    it('user can delete address', function (): void {
        $address = Address::factory()->create([
            'first_name' => 'Old first name',
            'type' => AddressType::Billing,
            'user_id' => $this->user->id,
        ]);

        Livewire::test(Addresses::class)
            ->call('removeAddress', $address->id);

        expect(Address::query()->count())
            ->toBe(0);
    });
})
    ->group('address');
