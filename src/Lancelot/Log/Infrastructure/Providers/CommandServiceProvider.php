<?php


namespace Lancelot\Log\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Lancelot\Log\UI\Console\CheckErrorsOverflowed;
use Lancelot\Log\UI\Console\CleanLogs;
use Lancelot\Log\UI\Console\Log;

class CommandServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $commands = [
            CheckErrorsOverflowed::class,
            CleanLogs::class,
            Log::class
        ];
        $this->commands($commands);
    }
}
