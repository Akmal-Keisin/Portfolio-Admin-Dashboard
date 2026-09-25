<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('telegram:digest')
    ->dailyAt(config('services.telegram.digest_at', '08:00'))
    ->timezone(config('services.telegram.timezone', 'UTC'));
