<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Customer;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Shopper\Core\Models\Address;

#[Layout('components.layouts.templates.account')]
final class Addresses extends Component
{
    public function setDefaultShipping(int $id): void
    {
        $address = Auth::user()->addresses()->findOrFail($id);

        Auth::user()->addresses()
            ->where('shipping_default', true)
            ->update(['shipping_default' => false]);

        $address->update(['shipping_default' => true]);

        $this->dispatch('notify', type: 'success', title: __('Default shipping address updated.'));
    }

    public function setDefaultBilling(int $id): void
    {
        $address = Auth::user()->addresses()->findOrFail($id);

        Auth::user()->addresses()
            ->where('billing_default', true)
            ->update(['billing_default' => false]);

        $address->update(['billing_default' => true]);

        $this->dispatch('notify', type: 'success', title: __('Default billing address updated.'));
    }

    public function removeAddress(int $id): void
    {
        Auth::user()->addresses()->findOrFail($id)->delete();

        $this->dispatch('notify', type: 'success', title: __('The address has been correctly removed from your list!'));

        $this->dispatch('addresses-updated');
    }

    #[On('addresses-updated')]
    public function render(): View
    {
        return view('livewire.pages.customer.addresses', [
            'addresses' => auth()->user()->addresses()->with('country')->get(),
        ])
            ->title(__('My addresses'));
    }
}
