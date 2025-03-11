<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Controllers\EditAssetController;

use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


$schedule = app(Schedule::class);
$schedule->call(function () {
    Log::info('Starting scheduled task from closure');
    try {
        Log::info('Starting Process Scheduled Tasks');
        $controller = new EditAssetController();
        $controller->processScheduledTasks();
        Log::info('Scheduled task completed successfully');
    } catch (\Exception $e) {
        Log::error('Error in scheduled task', ['error' => $e->getMessage()]);
    }
})->dailyAt('2:00');
