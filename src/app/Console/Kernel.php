<?php

namespace App\Console;
/* kernel untuk mendaftarkan command artisan */

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SyncRolesCommand;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SyncRolesCommand::class,
        \App\Console\Commands\ServeCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // tempat mendefinisikan jadwal command (cron)
    }

    protected function commands(): void
    {
        // muat definisi command dari route/console.php jika perlu
    }
}
