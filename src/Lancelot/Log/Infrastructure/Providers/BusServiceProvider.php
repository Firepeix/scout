<?php


namespace Lancelot\Log\Infrastructure\Providers;

use Lancelot\Log\Application\CheckErrors\CheckErrorsAlert;
use Lancelot\Log\Application\CheckErrors\CheckErrorsAlertCommandHandler;
use Lancelot\Log\Application\Clean\CleanLogsCommand;
use Lancelot\Log\Application\Clean\CleanLogsCommandHandler;
use Lancelot\Log\Application\Create\CreateLogCommand;
use Lancelot\Log\Application\Create\CreateLogCommandHandler;
use Lancelot\Log\Application\Write\WriteLogCommand;
use Lancelot\Log\Application\Write\WriteLogCommandHandler;
use Shared\Infrastructure\Providers\AbstractBusServiceProvider;

class BusServiceProvider extends AbstractBusServiceProvider
{
    protected array $commands = [
        CheckErrorsAlert::class => CheckErrorsAlertCommandHandler::class,
        CleanLogsCommand::class => CleanLogsCommandHandler::class,
        WriteLogCommand::class => WriteLogCommandHandler::class,
        CreateLogCommand::class => CreateLogCommandHandler::class
    ];
}
