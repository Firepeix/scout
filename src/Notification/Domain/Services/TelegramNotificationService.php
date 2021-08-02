<?php


namespace Notification\Domain\Services;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Notification\Domain\Message;
use Notification\Domain\ValueObject\TextMessage;

class TelegramNotificationService implements NotificationService
{
    private Telegram $telegram;
    private Request $request;
    
    public function __construct()
    {
        $this->telegram = new Telegram(config('telegram.token'), 'MangaScoutBot');
        $this->request = new Request();
    }
    
    public function send(Message $message): void
    {
        $this->request::sendMessage(['text' => $message->getContent(), 'chat_id' => config('telegram.roomId'), 'parse_mode' => 'HTML']);
    }
    
    public function createMessage(TextMessage $text): Message
    {
        return new Message($text);
    }
}
