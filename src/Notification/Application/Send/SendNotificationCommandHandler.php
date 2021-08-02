<?php

namespace Notification\Application\Send;

use Illuminate\Contracts\Queue\ShouldQueue;
use Notification\Domain\Services\NotificationService;
use Psr\Log\LoggerInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class SendNotificationCommandHandler  implements CommandHandlerInterface, ShouldQueue
{
    private LoggerInterface $logger;
    private NotificationService $service;
    
    public function __construct(LoggerInterface $logger, NotificationService $service)
    {
        $this->logger  = $logger;
        $this->service = $service;
    }
    
    public function handle(SendNotificationCommand|CommandInterface $command): ? CommandResponseInterface
    {
        $this->logger->info('Enviando Notificação');
        $this->service->send($this->service->createMessage($command->getMessage()));
        $this->logger->info('Notificação Enviada');
        return null;
    }
}
