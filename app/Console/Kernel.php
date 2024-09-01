<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:reporte-ingredientes')->dailyAt('23:58');
        $schedule->command('app:reporte-ingredientes')->dailyAt('23:59');
        $schedule->command('app:create-caja')->dailyAt('00:01');
        $schedule->command('app:create-caja')->dailyAt('00:02');
        $schedule->command('app:update-caja')->dailyAt('23:59');
        $schedule->command('app:update-caja')->dailyAt('23:58');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
