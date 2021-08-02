<?php


namespace Notification\Domain\Events;


class NewNotification
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
