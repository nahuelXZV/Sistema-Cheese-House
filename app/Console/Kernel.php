<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:reporte-ingredientes')->dailyAt('23:57');
        $schedule->command('app:reporte-ingredientes')->dailyAt('23:58');
        $schedule->command('app:reporte-ingredientes')->dailyAt('23:59');
        //$schedule->command('app:reporte-ingredientes')->everyMinute();
        // $schedule->command('app:reporte-ingredientes')->dailyAt('07:50');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
