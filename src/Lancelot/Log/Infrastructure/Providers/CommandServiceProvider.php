<?php


namespace Lancelot\Log\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Lancelot\Log\UI\Console\CheckErrorsOverflowed;
use Lancelot\Log\UI\Console\CleanLogs;

class CommandServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $commands = [
            CheckErrorsOverflowed::class,
            CleanLogs::class
        ];
        $this->commands($commands);
    }
}
