<?php


namespace App\Application\Manga\Listeners\Check;


use Illuminate\Contracts\Queue\ShouldQueue;
use Scout\Book\Domain\BookServiceInterface;
use Scout\Book\Domain\Events\Check\CheckBook;
use Scout\Source\Domain\SourceRepository;

class CheckMangaHandler implements ShouldQueue
{
    private BookServiceInterface $service;
    private SourceRepository $sourceRepository;
    
    public function __construct(BookServiceInterface $service, SourceRepository $sourceRepository)
    {
        $this->service = $service;
        $this->sourceRepository = $sourceRepository;
    }
    
    public function handle(CheckBook $checkBook) : void
    {
        $book = $checkBook->getBook();
        $source = $this->sourceRepository->findSourceByType($book->getSourceType());
        $this->service->checkBook($checkBook->getBook(), $source);
    }
}
