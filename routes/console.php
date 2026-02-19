<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:reset-demo')
    ->cron('0 3 */2 * *')
    ->withoutOverlapping()
    ->runInBackground();
