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
use Scout\Book\Domain\ValueObject\SourceType;
use Scout\Book\Domain\ValueObject\Title;
use Scout\Book\Infrastructure\Persistence\GoogleSheets\BookModel;
use Scout\Shared\Infrastructure\Persistence\AbstractRepository;
use Shared\Domain\ValueObject\Id;


class GoogleSheetBookRepository extends AbstractRepository implements BookRepositoryInterface
{
    private Factory $sheet;

    public function __construct(Factory $sheet)
    {
        parent::__construct();
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
    
    public function find(Id $id): mixed
    {
        #TODO Adicionar
        dd($id);
    }
    
    
    protected function map(BookModel $model): Book
    {
        return new Book(
            new BookId($model->getId()),
            new Title($model->getTitle()),
            new LastChapterRead($model->getLastReadChapter()),
            new ExternalId($model->getExternalId()),
            new SourceType($model->getSourceType())
        );
    }
    
    public function getMainBooks(string $id = null, string $name = null): Collection
    {
        if ($id === null && $name === null) {
            return $this->getAll();
        }
    
        return new Collection([$this->find(new Id($id))]);
    }
    
    public function getAll(): Collection
    {
        $books = $this->sheet->range('A1:G500')->get()->slice(1)->values();
        return $this->process($books);
    }
    
    private function filter(Collection $books) : Collection
    {
        return $books->filter(function (BookModel $book) {
            return $this->filterIgnored($book);
        });
    }
    
    private function filterIgnored(BookModel $book) : bool
    {
        if ($book->getIgnoreUntil() !== null) {
            return $book->getIgnoreUntil()->isPast();
        }
        
        return true;
    }
    
    private function process(Collection $books) : Collection
    {
        $books = $books->filter(fn (array $attributes) => !empty($attributes));
        $books->transform(fn (array $attributes) => new BookModel($attributes));
        return $this->filter($books)->map(fn ($model) => $this->map($model));
    }
}
