<?php

declare(strict_types=1);

namespace App\Livewire\Modals\Customer;


use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Livewire\Attributes\Validate;

use Shopper\Core\Models\Address;
use Shopper\Core\Models\Country;
use App\Actions\CountriesWithZone;
use Shopper\Core\Enum\AddressType;
use App\Actions\ZoneSessionManager;

final class AddressForm extends ModalComponent
{

    #[Validate('required|string')]
    public ?string $first_name = null;

    #[Validate('required|string')]
    public ?string $last_name = null;

    #[Validate('required|min:3')]
    public ?string $street_address;

    public ?string $street_address_plus = null;

    #[Validate('required')]
    public AddressType $type;

    public ?int $country_id = null;

    #[Validate('required|string')]
    public ?string $postal_code = null;

    #[Validate('required|string')]
    public ?string $city = null;

    public ?string $phone_number;

    public ?Address $address = null;

    public $countries;
    public function mount(?int $addressId = null): void
    {
        $this->address = $addressId
            ? Address::query()->findOrFail($addressId)
            : new Address();

        $this->countries = Country::whereIn('id', (new CountriesWithZone())
            ->handle()
            ->when(ZoneSessionManager::getSession() !== null, function ($query) {
                $query->where('zoneId', ZoneSessionManager::getSession()->zoneId);
            }))->pluck('name', 'id');
        $this->address->type = ($this->address->type === AddressType::Shipping) ? AddressType::Shipping : AddressType::Billing;

        if ($addressId && $this->address) {
            $this->fill([
                'first_name' => $this->address->first_name,
                'last_name' => $this->address->last_name,
                'street_address' => $this->address->street_address,
                'street_address_plus' => $this->address->street_address_plus,
                'type' => $this->address->type,
                'country_id' => $this->address->country_id,
                'postal_code' => $this->address->postal_code,
                'city' => $this->address->city,
                'phone_number' => $this->address->phone_number,
            ]);
        }

    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }


    public function save(): void
    {
        $this->validate();

        if ($this->address->id) {
            $this->address->update(array_merge($this->validate(), ['user_id' => auth()->id()]));
        } else {
            Address::query()->create(array_merge($this->validate(), ['user_id' => auth()->id()]));
        }

        Notification::make()
            ->title(__("The address has been successfully saved"))
            ->success()
            ->send();

        $this->dispatch('addresses-updated');

        $this->closeModal();
    }
    public function render(): View
    {
        return view('livewire.modals.customer.address-form', [
            'title' => $this->address->id
                ? __('Update address')
                : __('Add a new address'),
        ]);
    }
}
