<?php

declare(strict_types=1);

namespace App\Actions\Payment;

use App\Actions\ZoneSessionManager;
use App\Contracts\ManageOrder;
use App\Enums\PaymentType;
use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use NotchPay\NotchPay;
use NotchPay\Payment;
use Shopper\Core\Models\Order;

final class PayWithNotchPay implements ManageOrder
{
    public function handle(Order $order): mixed
    {
        session()->forget('checkout');

        NotchPay::setApiKey(
            apiKey: config('services.notchpay.public_key')
        );

        $amount = $order->total() + $order->shippingOption->price;
        $user = Auth::user();

        try {
            $payload = Payment::initialize([
                'amount' => $amount,
                'email' => $email = $user->email,
                'currency' => ZoneSessionManager::getSession()->currencyCode,
                'reference' => $user->id . '-' . $email . '-' . uniqid(),
                'callback' => route('notchpay-callback'),
                'description' => __('Order payment N° :number', ['number' => $order->number]),
            ]);

            Transaction::query()->create([
                'amount' => $payload->transaction->amount,
                'status' => $payload->transaction->status,
                'transaction_reference' => $payload->transaction->reference,
                'currency_code' => $payload->transaction->currency,
                'user_id' => $user->id,
                'order_id' => $order->id,
                'fees' => $payload->transaction->fee,
                'type' => TransactionType::OneTime(),
                'provider' => PaymentType::NotchPay(),
                'metadata' => [
                    'initiated_at' => $payload->transaction->created_at,
                ],
            ]);

            return redirect($payload->authorization_url);
        } catch (\NotchPay\Exceptions\ApiException $e) {
            session()->flash(
                'error',
                __('Unable to process payment, please try again later. Thank you')
            );

            return redirect()->route('order-confirmed', ['number' => $order->number]);
        }
    }
}