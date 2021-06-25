<?php


namespace App\Domain\Notification\Services;

use App\Domain\Notification\Message;

interface NotificationService
{
    public function send(Message $message, int $roomId) : void;
}
