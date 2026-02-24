<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Shopper\Core\Enum\OrderStatus;
use Shopper\Core\Enum\PaymentStatus;
use Shopper\Core\Models\Order;
use Shopper\Payment\Facades\Payment;
use Shopper\Payment\Models\PaymentTransaction;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $driver = Payment::driver('stripe');

        $result = $driver->handleWebhook(
            payload: ['_raw_body' => $request->getContent()],
            headers: [
                'stripe-signature' => $request->header('Stripe-Signature', ''),
            ],
        );

        if ($result->isIgnored()) {
            return response()->json(['status' => 'ignored']);
        }

        $transaction = PaymentTransaction::query()
            ->where('reference', $result->reference)
            ->first();

        if (! $transaction) {
            return response()->json(['status' => 'no_transaction'], 404);
        }

        $order = Order::query()->find($transaction->order_id);

        if (! $order) {
            return response()->json(['status' => 'no_order'], 404);
        }

        match ($result->action) {
            'authorized' => $order->update([
                'payment_status' => PaymentStatus::Authorized,
            ]),
            'captured' => $order->update([
                'payment_status' => PaymentStatus::Paid,
            ]),
            'failed', 'canceled' => $order->update([
                'status' => OrderStatus::Cancelled,
                'payment_status' => PaymentStatus::Voided,
            ]),
            'refunded' => $order->update([
                'status' => OrderStatus::Cancelled,
                'payment_status' => PaymentStatus::Refunded,
            ]),
            default => null,
        };

        return response()->json(['status' => 'handled']);
    }
}
