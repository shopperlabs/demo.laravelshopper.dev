<?php

declare(strict_types=1);


use App\Livewire\Modals\Customer\AddressForm;
use App\Livewire\Pages\Customer\Addresses;
use App\Models\User;
use Livewire\Livewire;
use Shopper\Core\Enum\AddressType;
use Shopper\Core\Models\Address;


beforeEach(function (): void {
    $this->user = User::factory()->create();
});

describe('Can Manage Addresse', function (): void {

    it('User can create Adresse', function (): void {

        Livewire::actingAs($this->user)
            ->test(AddressForm::class)
            ->set('first_name', 'Adresse first name')
            ->set('last_name', 'Adresse Last name')
            ->set('street_address', 'adresse street')
            ->set('street_address_plus', 'Adress street plus')
            ->set('type', AddressType::Billing)
            ->set('country_id', 1)
            ->set('postal_code', '33790')
            ->set('city', 'Adresse city')
            ->set('phone_number', '657293049')
            ->call('save')
            ->assertDispatched('addresses-updated');

        expect(Address::count())
            ->toBe(1);

    });

    it('User can edite Address', function (): void {
        $address = Address::factory()->create(['first_name' => 'Old first name', 'type' => AddressType::Billing,'user_id'  => $this->user->id]);

        Livewire::actingAs($this->user)
            ->test(AddressForm::class , ['addressId' => $address->id])
            ->set('first_name', 'New First name')
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

        expect(Address::get())
            ->toHaveCount(1)->first()->first_name->toEqual('New First name');
    });

    it('User can delete Address', function (): void {
        $address = Address::factory()->create(['first_name' => 'Old first name', 'type' => AddressType::Billing,'user_id' => $this->user->id]);

        Livewire::actingAs($this->user)
            ->test(Addresses::class)
            ->call('removeAddress',$address->id);

        expect(Address::count())
            ->toBe(0);

    });

})->group('Adresses');
