<?php


namespace Notification\UI\Listeners;


use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification\Application\Send\SendNotificationCommand;
use Notification\Domain\Events\NewNotification;
use Psr\Log\LoggerInterface;

class SendNotification implements ShouldQueue
{
    private LoggerInterface $logger;
    private Dispatcher $dispatcher;

    public function __construct(LoggerInterface $logger, Dispatcher $dispatcher)
    {
        $this->logger     = $logger;
        $this->dispatcher = $dispatcher;
    }
    
    public function handle(NewNotification $newNotification) : void
    {
        $this->dispatcher->dispatch(new SendNotificationCommand($newNotification->getMessage()));
        $this->logger->info('Termino do disparo da notificação');
    }
}
