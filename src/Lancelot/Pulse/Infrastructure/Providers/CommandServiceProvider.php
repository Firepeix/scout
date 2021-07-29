<?php


namespace Lancelot\Pulse\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Lancelot\Pulse\UI\Console\FirePulses;

class CommandServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $commands = [
            FirePulses::class
        ];
        $this->commands($commands);
    }
}
