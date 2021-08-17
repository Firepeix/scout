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
use Symfony\Component\Translation\Exception\NotFoundResourceException;


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
        $book = $this->sheet->range("A$id:G$id")->get()->first();
        if ($book === null || empty($book)) {
            throw new NotFoundResourceException('Livro não encontrado');
        }
        return $this->createBook(new BookModel($book));
    }
    
    public function updateBook(Book $book): void
    {
        $model = $this->createModel($book);
        $this->sheet->range("A{$model->getId()}")->update([$model->toGoogleRow()]);
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
        $books = $this->sheet->range('A1:G500')->get()->slice(1)->values();
        return $this->process($books, $filterIgnored);
    }
    
    private function filter(BookModel $book): bool
    {
        return $this->filterIgnored($book);
    }
    
    private function filterIgnored(BookModel $book) : bool
    {
        if ($book->getIgnoreUntil() !== null) {
            return $book->getIgnoreUntil()->isPast();
        }
        
        return true;
    }
    
    private function process(Collection $baseBooks, bool $filter) : Collection
    {
        $books = new Collection();
        $baseBooks->each(function (array $attributes) use ($filter, $books) {
            if (!empty($attributes)) {
                $book = new BookModel($attributes);
                if ($filter) {
                    if ($this->filter($book)) {
                        $books->push($this->createBook($book));
                    }
                    return;
                }
                $books->push($this->createBook($book));
            }
        });
        return $books;
    }
    
    private function createBook(BookModel $model) : Book
    {
        $book = new Book(
            new BookId($model->getId()),
            new Title($model->getTitle()),
            new LastChapterRead($model->getLastReadChapter()),
            new ExternalId($model->getExternalId()),
            new SourceType($model->getSourceType())
        );
    
        if ($model->getIgnoreUntil() !== null) {
            $book->setIgnoredUntil($model->getIgnoreUntil());
        }
    
        if ($model->getParentId() !== null) {
            $book->setParentId(new ParentId($model->getParentId()));
        }
    
        return $book;
    }
    
    private function createModel(Book $book) : BookModel
    {
        $model = BookModel::Create($book->getId(), $book->getTitle(), $book->getLastChapterRead(), $book->getExternalId(), $book->getSourceType()->value());
        if ($book->getIgnoredUntil() !== null) {
            $model->setIgnoreUntil($book->getIgnoredUntil());
        }
        
        if ($book->getParentId() !== null) {
            $model->setParentId($book->getParentId());
        }
        
        return $model;
    }
}
