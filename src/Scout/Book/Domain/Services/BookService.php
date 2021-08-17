<?php


namespace Scout\Book\Domain\Services;


use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;
use Scout\Book\Domain\Book;
use Scout\Book\Domain\BookServiceInterface;
use Scout\Book\Domain\ChapterCheckDecision;
use Scout\Book\Domain\Events\Check\AfterBookCheck;
use Scout\Book\Domain\Events\Check\CheckBook;
use Scout\Book\Domain\Exceptions\CheckBookException;
use Scout\Book\Domain\ValueObject\ExternalId;
use Scout\Book\Domain\ValueObject\LastChapterRead;
use Scout\Book\Domain\ValueObject\SourceType;
use Scout\Book\Domain\ValueObject\Title;
use Scout\Source\Domain\SourcedObject;
use Scout\Source\Domain\SourceInterface;
use Scout\Source\Domain\SourceRepository;

class BookService implements BookServiceInterface
{
    private SourceRepository $sourceRepository;
    private LoggerInterface $logger;
    
    public function __construct(SourceRepository $sourceRepository, LoggerInterface $logger)
    {
        $this->sourceRepository = $sourceRepository;
        $this->logger           = $logger;
    }
    
    public function getFollowedBooks(SourceInterface $source): Collection
    {
        return $source->getFollowedSourcedObjects()->map(function (SourcedObject $object) {
            $id = new ExternalId($object->getSourcedId()->value());
            $title = new Title($object->getSourcedName()->value());
            $type = new SourceType($object->getSourcedType()->value());
            return new Book(null, $title, new LastChapterRead(), $id, $type);
        });
    }
    
    public function checkBooksSync(Collection $books, Closure $onDone): void
    {
        $sources = $this->sourceRepository->getAll()->keyBy(fn (SourceInterface $source) => $source->getType()->value());
        $books->each(function (Book $book) use ($onDone, $sources){
            $this->checkBook($book, $sources[$book->getSourceType()->value()], $onDone);
        });
    }
    
    public function checkBook(Book $book, SourceInterface $source, Closure $success = null) : void
    {
        $decision = $this->checkChapter($book, $source);
        if ($success !== null) {
            $success($decision->hasNewChapter() ? $decision->getNewChapter() : null, $book->getTitle());
        }
        event(new AfterBookCheck($book, $decision));
    }
    
    public function checkChapter(Book $book, SourceInterface $source): ChapterCheckDecision
    {
        try {
            $lastChapter = $source->getLastUpdate($book);
            $decision = new ChapterCheckDecision($lastChapter, $book->getLastChapterRead());
            $this->logger->info('Manga Checado', ['Manga' => $book->toArray(), 'Source' => $source->toArray(), 'Decision' => $decision->toArray(), 'Event' => CheckBook::NAME]);
            return $decision;
        } catch (Exception $exception) {
            throw new CheckBookException($book, $exception);
        }
    }
    
    public function checkBooksAsync(Collection $books): void
    {
        $books->each(function (Book $book){
            sleep(1);
            event(new CheckBook($book));
        });
    }
    
    public function postponeBook(Book $book, Carbon $until): void
    {
        $book->setIgnoredUntil($until);
    }
    
    public function read(Book $book, LastChapterRead $readUpTo): void
    {
        $book->read($readUpTo);
    }
    
    public function turnOn(Book $book): void
    {
        $book->turnOn();
    }
}
