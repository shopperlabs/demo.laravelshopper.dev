<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Events\PaymentInitialize;
use App\Models\Transaction;
use Illuminate\Http\Request;
use NotchPay\NotchPay;
use NotchPay\Payment;
use Shopper\Core\Enum\OrderStatus;

class NotchPayCallBackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
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
                    value: __('Votre paiement a été annulé veuillez relancer au niveau de votre profil.')
                );
            } else {
                $transaction->order->update([
                    'status' => OrderStatus::Paid(),
                ]);

                // @ToDO Envoie de mail de notification de remerciement pour la commande à l'utilisateur
                event(new PaymentInitialize($transaction));

                session()->flash(
                    key: 'status',
                    value: __('Votre paiement a été fait avec succès.')
                );
            }

        } catch (\NotchPay\Exceptions\ApiException $e) {
            session()->flash(
                key: 'error',
                value: __('Une erreur s\'est produite lors de votre paiement. Veuillez relancer sur votre profil.')
            );
        }

        return redirect()->route('order-confirmed', ['number' => $transaction->order->number]);
    }
}
