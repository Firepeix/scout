<?php


namespace Lancelot\Log\Infrastructure\Providers;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Lancelot\Log\Application\CheckErrors\CheckErrorsAlert;
use Lancelot\Log\Application\CheckErrors\CheckErrorsAlertCommandHandler;
use Lancelot\Log\Application\Clean\CleanLogsCommand;
use Lancelot\Log\Application\Clean\CleanLogsCommandHandler;
use Lancelot\Log\Application\Create\CreateLogCommand;
use Lancelot\Log\Application\Create\CreateLogCommandHandler;
use Lancelot\Log\Application\Write\WriteLogCommand;
use Lancelot\Log\Application\Write\WriteLogCommandHandler;

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
            CleanLogsCommand::class => CleanLogsCommandHandler::class,
            WriteLogCommand::class => WriteLogCommandHandler::class,
            CreateLogCommand::class => CreateLogCommandHandler::class
        ];
        Bus::map($commands);
    }
}
