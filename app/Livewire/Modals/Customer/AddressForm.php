<?php

declare(strict_types=1);

namespace App\Livewire\Modals\Customer;

use App\Traits\WithAddressAttributes;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

use Shopper\Core\Models\Address;
use Shopper\Core\Models\Country;
use App\Actions\CountriesWithZone;
use App\Actions\ZoneSessionManager;

final class AddressForm extends ModalComponent implements HasForms
{
    use InteractsWithForms;
    use WithAddressAttributes;

    public array $data = [];

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

        if($addressId && $this->address) $this->setFormDataForUpdate($this->address);
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }


    public function save(): void
    {
        $this->validate();

        if ($this->address->id) {
            $this->address->update($this->getFormData());
        } else {
            Address::query()->create($this->getFormData());
        }

        Notification::make()
            ->title(__("The address has been successfully saved"))
            ->success()
            ->send();

        $this->dispatch('addresses-updated');

        $this->closeModal();
    }

    private function getFormData(){
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'street_address' => $this->streetAddress,
            'street_address_plus' => $this->streetAddressPlus,
            'type' => $this->type,
            'country_id' => $this->countryId,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'phone_number' => $this->phoneNumber,
            'user_id' => auth()->id(),
        ];
    }

    private function setFormDataForUpdate(Address $address){
        return [
            $this->firstName = $address->first_name,
            $this->lastName = $address->last_name,
            $this->streetAddress = $address->street_address,
            $this->streetAddressPlus = $address->street_address_plus,
            $this->type = $address->type,
            $this->countryId = $address->country_id,
            $this->postalCode = $address->postal_code,
            $this->city = $address->city,
            $this->phoneNumber = $address->phone_number,
        ];
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
