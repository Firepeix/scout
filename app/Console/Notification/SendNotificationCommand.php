<?php


namespace App\Console\Notification;

use App\Domain\Notification\Services\NotificationService;
use App\Domain\Notification\TextMessage;
use Illuminate\Console\Command;

class SendNotificationCommand extends Command
{
    protected $signature = 'notification:send {message}';
    
    private NotificationService $service;
    private TextMessage $message;
    
    public function __construct(NotificationService $service, TextMessage $message)
    {
        parent::__construct();
        $this->service = $service;
        $this->message = $message;
    }
    
    public function handle() : void
    {
        $message = $this->message->init($this->argument('message'));
        $this->service->send($message, (int) env('CHAT_ID'));
    }
    
}
