<?php

namespace App\Console;

use App\Console\Manga\CheckChaptersCommand;
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
        CheckChaptersCommand::class,
        SendNotificationCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('manga:check-chapters --async')->everyFiveMinutes();
        $schedule->command('manga:check-chapters --batch=1 --async')->everyTenMinutes();
        $schedule->command('manga:check-chapters --batch=2 --async')->everyFifteenMinutes();
        $schedule->command('manga:check-chapters --batch=3 --async')->everyThirtyMinutes();
        $schedule->command('manga:check-chapters --batch=4 --async')->hourly();
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
