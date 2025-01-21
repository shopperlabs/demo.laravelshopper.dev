<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Customer;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Core\Models\Order;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('components.layouts.templates.account')]
final class Orders extends Component
{
    use WithPagination;

    public function showInvoice(int $id): StreamedResponse
    {
        $order = Order::with(['items', 'shippingOption', 'shippingAddress', 'paymentMethod'])
            ->where('id', $id)
            ->firstOrFail();

        $data = $order->toArray();
        dd($data);
        $pdf = Pdf::loadView('pdf.invoice', [
            'data' => $data,
            'total' => shopper_money_format($order->total() + $order->shippingOption?->price)
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $order['number'] . '.pdf');
    }

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
