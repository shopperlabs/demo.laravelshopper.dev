<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Shopper\Core\Models\User as Authenticatable;

final class User extends Authenticatable implements MustVerifyEmail
{
    //
}
