<?php


namespace Lancelot\Pulse\Infrastructure\Providers;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Lancelot\Pulse\Application\Fire\FirePulsesCommand;
use Lancelot\Pulse\Application\Fire\FirePulsesCommandHandler;

class BusServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        $this->registerHandlers();
    }
    
    private function registerHandlers()
    {
        $commands = [
            FirePulsesCommand::class => FirePulsesCommandHandler::class
        ];
        Bus::map($commands);
    }
}
