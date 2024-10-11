<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Customer;

use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Shopper\Core\Models\Address;

#[Layout('components.layouts.templates.account')]
final class Addresses extends Component
{
    public function removeAddress(int $id): void
    {
        Address::query()->find($id)->delete();

        Notification::make()
            ->title(__("L'adresse a été correctement supprimée de votre liste!"))
            ->success()
            ->send();

        $this->dispatch('addresses-updated');
    }

    #[On('addresses-updated')]
    public function render(): View
    {
        return view('livewire.pages.customer.addresses', [
            'addresses' => auth()->user()->addresses,
        ])
            ->title(__('Mes adresses'));
    }
}
