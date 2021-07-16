<?php


namespace App\Application\Manga\Listeners\Check;


use App\Domain\Notification\Services\NotificationService;
use App\Domain\Notification\TextMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Scout\Book\Domain\Events\Check\AfterBookCheck;

class NewChapterSendNotification implements ShouldQueue
{
    private NotificationService $service;
    private TextMessage $message;
    
    public function __construct(NotificationService $service, TextMessage $message)
    {
        $this->service = $service;
        $this->message = $message;
    }
    
    public function handle(AfterBookCheck $afterBookCheck) : void
    {
        $decision = $afterBookCheck->getDecision();
        $book = $afterBookCheck->getBook();
        if ($decision->hasNewChapter()) {
            $message = $this->message->init("O manga <b>{$book->getTitle()}</b> tem o novo capitulo: <b>{$decision->getNewChapter()}</b>");
            $this->service->send($message, (int) env('CHAT_ID'));
        }
    }
}
