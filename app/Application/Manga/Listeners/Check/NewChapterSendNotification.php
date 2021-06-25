<?php


namespace App\Application\Manga\Listeners\Check;


use App\Application\Manga\Events\Check\MangaWasChecked;
use App\Domain\Notification\Services\NotificationService;
use App\Domain\Notification\TextMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewChapterSendNotification implements ShouldQueue
{
    private NotificationService $service;
    private TextMessage $message;
    
    public function __construct(NotificationService $service, TextMessage $message)
    {
        $this->service = $service;
        $this->message = $message;
    }
    
    public function handle(MangaWasChecked $mangaWasChecked) : void
    {
        $decision = $mangaWasChecked->getDecision();
        $manga = $mangaWasChecked->getManga();
        if ($decision->hasNewChapter()) {
            $message = $this->message->init("O manga <b>{$manga->getName()}</b> tem o novo capitulo: <b>{$decision->getNewChapter()}</b>");
            $this->service->send($message, (int) env('CHAT_ID'));
        }
    }
}
