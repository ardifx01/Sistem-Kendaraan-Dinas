<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Run daily at 08:00 to check vehicles due for service
        $schedule->command('service:notify-due')->dailyAt('08:00');
    }

    protected function commands(): void
    {
        // Load commands from Commands directory
        $this->load(__DIR__.'/Commands');
    }
}
