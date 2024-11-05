<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Customer;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.templates.account')]
final class Orders extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.pages.customer.orders.index', [
            'orders' => auth()->user()
                ->orders()
                ->with(['items', 'items.product', 'shippingOption', 'shippingAddress', 'billingAddress'])
                ->latest()
                ->simplePaginate(3),
        ])
            ->title(__('My orders'));
    }
}
