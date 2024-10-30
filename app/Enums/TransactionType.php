<?php

declare(strict_types=1);

namespace App\Enums;

use Shopper\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string OneTime()
 * @method static string Recurring()
 * @method static string Instalments()
 */
enum TransactionType: string
{
    use HasEnumStaticMethods;

    case OneTime = 'one-time';

    case Recurring = 'recurring';

    case Instalments = 'instalments';
}
