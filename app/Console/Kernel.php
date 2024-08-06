<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Daftar command Anda di sini
        \App\Console\Commands\DeductMonthlyFees::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('fees:deduct')->monthly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
