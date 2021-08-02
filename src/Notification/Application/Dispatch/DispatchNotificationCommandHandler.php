<?php

namespace Notification\Application\Dispatch;

use Illuminate\Contracts\Queue\ShouldQueue;
use Notification\Domain\Events\NewNotification;
use Psr\Log\LoggerInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class DispatchNotificationCommandHandler  implements CommandHandlerInterface, ShouldQueue
{
    private LoggerInterface $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger     = $logger;
    }
    
    public function handle(DispatchNotificationCommand|CommandInterface $command): ? CommandResponseInterface
    {
        $this->logger->info('Disparando Notificação');
        event(new NewNotification($command->getMessage()));
        return null;
    }
}
