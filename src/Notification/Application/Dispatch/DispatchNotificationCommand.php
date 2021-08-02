<?php


namespace Notification\Application\Dispatch;

use Shared\Domain\Bus\CommandInterface;

class DispatchNotificationCommand implements CommandInterface
{
    private string $message;
    
    public function __construct(string $message)
    {
        $this->message = $message;
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }
}
