<?php

namespace Lancelot\Log\Infrastructure\Listeners;

use App\Domain\Notification\Services\NotificationService;
use App\Domain\Notification\TextMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lancelot\Log\Infrastructure\Events\AlertErrorsOverflowed;

class SendAlertToTelegramNotification implements ShouldQueue
{
    private NotificationService $service;
    private TextMessage $message;
    
    public function __construct(NotificationService $service, TextMessage $message)
    {
        $this->service = $service;
        $this->message = $message;
    }
    
    public function handle(AlertErrorsOverflowed $alertErrorsOverflowed) : void
    {
        $message = $this->message->init("Alerta Temos novos erros na aplicação <b>Scout</b> Alerta");
        $this->service->send($message, (int) env('CHAT_ID'));
    }
}
