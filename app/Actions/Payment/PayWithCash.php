<?php

declare(strict_types=1);

namespace App\Actions\Payment;

use App\CheckoutSession;
use App\Contracts\ManageOrder;
use Shopper\Core\Models\Order;

final class PayWithCash implements ManageOrder
{
    public function handle(Order $order): mixed
    {
        session()->forget(CheckoutSession::KEY);

        return to_route('order-confirmed', ['number' => $order->number]);
    }
}
