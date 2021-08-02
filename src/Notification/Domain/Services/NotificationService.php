<?php


namespace Notification\Domain\Services;

use Notification\Domain\Message;
use Notification\Domain\ValueObject\TextMessage;

interface NotificationService
{
    public function send(Message $message) : void;
    
    public function createMessage(TextMessage $text) : Message;
}
