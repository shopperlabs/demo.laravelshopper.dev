<?php

declare(strict_types=1);

namespace App\Livewire\Modals\Customer;

use App\Actions\CountriesWithZone;
use App\Actions\ZoneSessionManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Shopper\Core\Enum\AddressType;
use Shopper\Core\Models\Address;
use Shopper\Core\Models\Country;

final class AddressForm extends Component
{
    public bool $showModal = false;

    #[Validate('required|string')]
    public ?string $first_name = null;

    #[Validate('required|string')]
    public ?string $last_name = null;

    #[Validate('required|min:3')]
    public ?string $street_address = null;

    #[Validate('nullable|string')]
    public ?string $street_address_plus = null;

    #[Validate('required')]
    public AddressType $type = AddressType::Billing;

    #[Validate('required')]
    public ?int $country_id = null;

    #[Validate('required|string')]
    public ?string $postal_code = null;

    #[Validate('required|string')]
    public ?string $city = null;

    #[Validate('nullable|string')]
    public ?string $state = null;

    #[Validate('nullable|string')]
    public ?string $phone_number = null;

    public ?Address $address = null;

    public Collection $countries;

    public function mount(?int $addressId = null): void
    {
        $this->address = $addressId
            ? Address::query()->findOrFail($addressId)
            : new Address;

        $this->countries = Country::query()
            ->whereIn(
                column: 'id',
                values: (new CountriesWithZone)
                    ->handle()
                    ->where('zoneId', ZoneSessionManager::getSession()?->zoneId)->pluck('countryId')
            )
            ->pluck('name', 'id');

        $this->country_id = ZoneSessionManager::getSession()?->countryId;

        if ($addressId && $this->address->id) {
            $this->fill(array_merge($this->address->toArray(), ['type' => $this->address->type]));
        }
    }

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->address->exists) {
            $this->address->update(array_merge($validated, ['user_id' => Auth::id()]));
        } else {
            Address::query()->create(array_merge($validated, ['user_id' => Auth::id()]));

            $this->reset('first_name', 'last_name', 'street_address', 'street_address_plus', 'country_id', 'postal_code', 'city', 'state', 'phone_number');
            $this->type = AddressType::Billing;
        }

        $this->dispatch('notify', type: 'success', title: __('The address has been successfully saved'));

        $this->showModal = false;

        $this->dispatch('addresses-updated');
    }

    public function render(): View
    {
        return view('livewire.modals.customer.address-form', [
            'title' => $this->address->id
                ? __('Update address')
                : __('Add new address'),
        ]);
    }
}
