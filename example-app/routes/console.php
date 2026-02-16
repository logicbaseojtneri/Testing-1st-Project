<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Send daily task reminders (upcoming deadlines + overdue) at 8:00 AM
Schedule::command('app:send-task-reminders')->dailyAt('08:00');
