<?php


namespace Scout\Book\Infrastructure\Persistence\Repositories;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Revolution\Google\Sheets\Contracts\Factory;
use Scout\Book\Domain\Book;
use Scout\Book\Domain\BookRepositoryInterface;
use Scout\Book\Domain\ValueObject\ExternalId;
use Scout\Book\Domain\ValueObject\Id as BookId;
use Scout\Book\Domain\ValueObject\LastChapterRead;
use Scout\Book\Domain\ValueObject\ParentId;
use Scout\Book\Domain\ValueObject\SourceType;
use Scout\Book\Domain\ValueObject\Title;
use Scout\Book\Infrastructure\Persistence\GoogleSheets\BookModel;
use Shared\Domain\ValueObject\Id;


class GoogleSheetBookRepository implements BookRepositoryInterface
{
    private Factory $sheet;

    public function __construct(Factory $sheet)
    {
        $this->sheet = $sheet->spreadsheet(env('SHEET_ID'))->sheet('Main');
    }
    
    public function insert(Collection $books): void
    {
        $startId = $this->sheet->range('A1:A500')->get()->count();
        $rows = $this->prepareForInsert($books, $startId - 1);
        $this->sheet->range('A1:G500')->append($rows->toArray());
    }
    
    private function prepareForInsert(Collection $books, int $startId) : Collection
    {
        $ignoreUntil = Carbon::now()->addYear()->toDateTimeString();
        return $books->map(function (Book $book) use (&$startId, $ignoreUntil) {
           $startId++;
           return [
               $startId,
               $book->getTitle()->value(),
               0,
               $book->getId()->value(),
               $ignoreUntil,
               $book->getSourceType()->value()
           ];
        });
    }
    
    public function find(Id $id): Book
    {
        $books = $this->getAll(false);
        dd($books);
    }
    
    public function updateBook(Book $book): void
    {
    
    }
    
    
    public function getMainBooks(string $id = null, string $name = null, bool $filterIgnored = true): Collection
    {
        if ($id === null && $name === null) {
            return $this->getAll($filterIgnored);
        }
    
        return new Collection([$this->find(new Id($id))]);
    }
    
    private function getAll(bool $filterIgnored): Collection
    {
        //$books = $this->sheet->range('A1:G500')->get()->slice(1)->values();
        $books = cache()->get('asd');
        return $this->process($books, $filterIgnored);
    }
    
    private function filter(Collection $books, bool $filterIgnored) : Collection
    {
        if ($filterIgnored) {
            return $books->filter(function (BookModel $book) {
                return $this->filterIgnored($book);
            });
        }
        
       return $books;
    }
    
    private function filterIgnored(BookModel $book) : bool
    {
        if ($book->getIgnoreUntil() !== null) {
            return $book->getIgnoreUntil()->isPast();
        }
        
        return true;
    }
    
    private function process(Collection $baseBooks, bool $filterIgnored) : Collection
    {
        $books = new Collection();
        $baseBooks->each(fn (array $attributes, int $index) => !empty($attributes) ? $books->push(new BookModel($index + 1, $attributes)) : null);
        return $this->filter($books, $filterIgnored)->map(function (BookModel $model) {
            $book = new Book(
                new BookId($model->getId()),
                new Title($model->getTitle()),
                new LastChapterRead($model->getLastReadChapter()),
                new ExternalId($model->getExternalId()),
                new SourceType($model->getSourceType())
            );
    
            $book->setInternalId($model->getPosition());
            
            if ($model->getIgnoreUntil() !== null) {
                $book->setIgnoredUntil($model->getIgnoreUntil());
            }
    
            if ($model->getParentId() !== null) {
                $book->setParentId(new ParentId($model->getParentId()));
            }
    
            return $book;
        });
    }
}
