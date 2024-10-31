<?php

declare(strict_types=1);

namespace App\Enums;

use Shopper\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Stripe()
 * @method static string NotchPay()
 * @method static string Cash()
 */
enum PaymentType: string
{
    use HasEnumStaticMethods;

    case Stripe = 'stripe';

    case NotchPay = 'notchpay';

    case Cash = 'cash';
}
