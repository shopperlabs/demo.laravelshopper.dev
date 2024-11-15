<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Events\PaymentInitialize;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use NotchPay\NotchPay;
use NotchPay\Payment;
use Shopper\Core\Enum\OrderStatus;

class NotchPayCallBackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::with('order')
            ->where('transaction_reference', $request->get('reference'))
            ->firstOrFail();

        NotchPay::setApiKey(
            apiKey: config('services.notchpay.public_key')
        );

        try {
            $verifyTransaction = Payment::verify(reference: $request->get('reference'));
            $transaction->update(['status' => $verifyTransaction->transaction->status]); // @phpstan-ignore-line

            // @phpstan-ignore-next-line
            if ($verifyTransaction->transaction->status === TransactionStatus::Canceled()) {
                session()->flash(
                    key: 'error',
                    value: __('Your payment has been cancelled, please reactivate your profile.')
                );
            } else {
                $transaction->order->update([
                    'status' => OrderStatus::Paid(),
                ]);

                event(new PaymentInitialize($transaction));

                session()->flash(
                    key: 'status',
                    value: __('Your payment has been made successfully.')
                );
            }

        } catch (\NotchPay\Exceptions\ApiException $e) {
            session()->flash(
                key: 'error',
                value: __('An error occurred during your payment. Please relaunch your profile.')
            );
        }

        return redirect()->route('order-confirmed', ['number' => $transaction->order->number]);
    }
}
