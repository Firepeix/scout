<?php

namespace Executor\Manager\Infrastructure\Persistence\Repositories;
use Executor\Manager\Domain\ExternalCommand;
use Executor\Manager\Domain\Repositories\ExternalCommandRepositoryInterface;
use Executor\Manager\Infrastructure\Persistence\GoogleSheets\ExternalCommandModel;
use Illuminate\Support\Collection;
use Revolution\Google\Sheets\Contracts\Factory;

class GoogleSheetExternalCommandRepository implements ExternalCommandRepositoryInterface
{
    private Factory $sheet;

    public function __construct(Factory $sheet)
    {
        $this->sheet = $sheet->spreadsheet(config('google.sheets.operations'))->sheet(config('app.name'));
    }
    
    public function getExternalCommands(): Collection
    {
        $externalCommands = $this->sheet->range('A1:E500')->get()->slice(1)->values();
        return $this->process($externalCommands);
    }
    
    public function update(ExternalCommand $command): void
    {
        //$model = $this->createModel($book);
        //$this->sheet->range("A{$model->getId()}")->update([$model->toGoogleRow()]);
    }
    
    public function delete(ExternalCommand $command): void
    {
        // TODO: Implement delete() method.
    }
    
    
    private function process(Collection $rawCommands) : Collection
    {
        $commands = new Collection();
        $rawCommands->each(function (array $attributes, int $row) use ($commands) {
            if (!empty($attributes)) {
                $sheetOffset = 2;
                $commands->push($this->createCommand(ExternalCommandModel::Create($row + $sheetOffset, $attributes)));
            }
        });
        return $commands;
    }
    
    private function createCommand(ExternalCommandModel $model) : ExternalCommand
    {
        $command = new Book(
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
    //
    //private function createModel(Book $book) : BookModel
    //{
    //    $model = BookModel::Create($book->getId(), $book->getTitle(), $book->getLastChapterRead(), $book->getExternalId(), $book->getSourceType()->value());
    //    if ($book->getIgnoredUntil() !== null) {
    //        $model->setIgnoreUntil($book->getIgnoredUntil());
    //    }
    //
    //    if ($book->getParentId() !== null) {
    //        $model->setParentId($book->getParentId());
    //    }
    //
    //    return $model;
    //}
}
