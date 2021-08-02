<?php


namespace Notification\Infrastructure\Providers;


use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Notification\Application\Dispatch\DispatchNotificationCommand;
use Notification\Application\Dispatch\DispatchNotificationCommandHandler;
use Notification\Application\Send\SendNotificationCommand;
use Notification\Application\Send\SendNotificationCommandHandler;

class BusServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerHandlers();
    }
    
    private function registerHandlers()
    {
        $commands = [
            DispatchNotificationCommand::class => DispatchNotificationCommandHandler::class,
            SendNotificationCommand::class => SendNotificationCommandHandler::class
        ];
        Bus::map($commands);
    }
}
