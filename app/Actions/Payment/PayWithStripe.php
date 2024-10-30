<?php

declare(strict_types=1);

namespace App\Actions\Payment;

use App\Contracts\ManageOrder;
use Shopper\Core\Models\Order;

final class PayWithStripe implements ManageOrder
{
    public function handle(Order $order): mixed
    {
        session()->forget('checkout');

        return redirect()->route('order-confirmed', ['number' => $order->number]);
    }
}
