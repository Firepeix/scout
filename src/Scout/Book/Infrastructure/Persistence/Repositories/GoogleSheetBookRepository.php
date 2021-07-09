<?php


namespace Scout\Book\Infrastructure\Persistence\Repositories;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Revolution\Google\Sheets\Contracts\Factory;
use Scout\Book\Domain\Book;
use Scout\Book\Domain\BookRepositoryInterface;
use Scout\Shared\Infrastructure\Persistence\AbstractRepository;

class GoogleSheetBookRepository extends AbstractRepository implements BookRepositoryInterface
{
    private const IGNORE_UNTIL_FIELD = 4;
    
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
        $this->sheet->range('A1:E500')->append($rows->toArray());
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
               json_encode([['type' => $book->getSourceType()->value(), 'externalId' => $book->getId()->value()]]),
               self::IGNORE_UNTIL_FIELD => $ignoreUntil,
           ];
        });
    }
    
    protected function map($model): mixed
    {
        // TODOs: Implement map() method.
        return null;
    }
}
