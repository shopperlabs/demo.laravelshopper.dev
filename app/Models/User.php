<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Shopper\Core\Models\Contracts\ShopperUser as InteractWithShopperUser;
use Shopper\Core\Traits\ShopperUser;

final class User extends Authenticatable implements InteractWithShopperUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    use ShopperUser;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'last_login_at',
        'last_login_ip',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
}
