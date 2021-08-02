<?php


namespace Notification\Application\Send;

use Notification\Domain\ValueObject\TextMessage;
use Shared\Domain\Bus\CommandInterface;

class SendNotificationCommand implements CommandInterface
{
    private string $message;
    
    public function __construct(string $message)
    {
        $this->message = $message;
    }
    
    public function getMessage(): TextMessage
    {
        return new TextMessage($this->message);
    }
}
