<?php

namespace Executor\Manager\Infrastructure\Persistence\Repositories;
use Executor\Manager\Domain\ExternalCommand;
use Executor\Manager\Domain\Repositories\ExternalCommandRepositoryInterface;
use Executor\Manager\Domain\ValueObject\Body;
use Executor\Manager\Domain\ValueObject\CommandName;
use Executor\Manager\Domain\ValueObject\ResponseCode;
use Executor\Manager\Infrastructure\Persistence\GoogleSheets\ExternalCommandModel;
use Illuminate\Support\Collection;
use Revolution\Google\Sheets\Contracts\Factory;
use Shared\Domain\ValueObject\Id;

class GoogleSheetExternalCommandRepository implements ExternalCommandRepositoryInterface
{
    private Factory $sheet;

    public function __construct(Factory $sheet)
    {
        $this->sheet = clone $sheet->spreadsheet(config('google.sheets.operations'))->sheet(config('app.name'));
    }
    
    public function getExternalCommands(): Collection
    {
        $externalCommands = $this->sheet->range('A1:E500')->get()->slice(1)->values();
        return $this->process($externalCommands);
    }
    
    public function update(ExternalCommand $command): void
    {
        $model = $this->createModel($command);
        $this->sheet->range("A{$model->getId()}")->update([$model->toSheetRow()]);
    }
    
    public function delete(ExternalCommand $command): void
    {
        $this->sheet->range("A{$command->getId()->value()}")->update([ExternalCommandModel::emptySheetRow()]);
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
        $command = new ExternalCommand(
            id: new Id($model->getId()),
            commandName: new CommandName($model->getCommandName()),
            body: new Body($model->getBody()),
            createdAt: $model->getCreatedAt()
        );
        
        if ($model->hasCompleted() && $model) {
            $command->complete(ResponseCode::define($model->getResponseCode()->unwrap()), new Body($model->getResponseBody()->unwrapOr("")));
        }
        
        return $command;
    }
    
    private function createModel(ExternalCommand $command) : ExternalCommandModel
    {
        return new ExternalCommandModel(
            id:           $command->getId()->value(),
            commandName:  $command->getName()->value(),
            createdAt:    $command->getCreatedAt(),
            body:         $command->getBody()->string(),
            responseCode: $command->getResponseCode()->map(fn (ResponseCode $code) => $code->value()),
            responseBody: $command->getResponseBody()->map(fn (Body $code) => $code->string())
        );
    }
}
