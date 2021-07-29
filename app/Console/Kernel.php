<?php

namespace App\Console;

use App\Console\Notification\SendNotificationCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendNotificationCommand::class
    ];

    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('log:check-error-overflow')->everyThirtyMinutes();
        $schedule->command('manga:check-chapters --batch-size=30 --async')->everyTenMinutes();
        $schedule->command('manga:check-chapters --batch-size=30 --batch=1 --async')->cron('*/12 * * * *');
        //$schedule->command('manga:check-chapters --batch-size=30 --batch=2 --async')->cron('*/23 * * * *');
        //$schedule->command('manga:check-chapters --batch-size=30 --batch=3 --async')->cron('*/36 * * * *');
        //$schedule->command('manga:check-chapters --batch-size=30 --batch=4 --async')->cron('31 */2 * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
