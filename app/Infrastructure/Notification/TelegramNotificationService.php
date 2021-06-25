<?php


namespace App\Infrastructure\Notification;


use App\Domain\Notification\Message;
use App\Domain\Notification\Services\NotificationService;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class TelegramNotificationService implements NotificationService
{
    private Telegram $telegram;
    private Request $request;
    
    public function __construct()
    {
        $this->telegram = new Telegram(env('NOTIFICATION_TOKEN'), 'MangaScoutBot');
        $this->request = new Request();
    }
    
    public function send(Message $message, int $roomId): void
    {
        $this->request::sendMessage(['text' => $message->getContent(), 'chat_id' => $roomId, 'parse_mode' => 'HTML']);
    }
}
