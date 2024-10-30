<?php

declare(strict_types=1);

namespace App\Contracts;

use Shopper\Core\Models\Order;

interface ManageOrder
{
    public function handle(Order $order): mixed;
}
