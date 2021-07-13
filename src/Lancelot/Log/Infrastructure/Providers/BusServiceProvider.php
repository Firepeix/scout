<?php


namespace Lancelot\Log\Infrastructure\Providers;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Lancelot\Log\Application\CheckErrors\CheckErrorsAlert;
use Lancelot\Log\Application\CheckErrors\CheckErrorsAlertCommandHandler;
use Lancelot\Log\Application\Clean\CleanLogsCommand;
use Lancelot\Log\Application\Clean\CleanLogsCommandHandler;

class BusServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        $this->registerHandlers();
    }
    
    private function registerHandlers()
    {
        $commands = [
            CheckErrorsAlert::class => CheckErrorsAlertCommandHandler::class,
            CleanLogsCommand::class => CleanLogsCommandHandler::class
        ];
        Bus::map($commands);
    }
}
