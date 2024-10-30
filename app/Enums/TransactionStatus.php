<?php

declare(strict_types=1);

namespace App\Enums;

use Shopper\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Pending()
 * @method static string Complete()
 * @method static string Canceled()
 * @method static string Failed()
 */
enum TransactionStatus: string
{
    use HasEnumStaticMethods;

    case Pending = 'pending';

    case Complete = 'complete';

    case Canceled = 'canceled';

    case Failed = 'failed';
}
