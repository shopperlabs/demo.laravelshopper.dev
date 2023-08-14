<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

final class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ( ! $request->expectsJson()) {
            return route('login');
        }

        return null;
    }
}
