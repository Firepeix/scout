<?php

namespace Executor\Manager\Application\Execute;

use Executor\Manager\Domain\Repositories\ExternalCommandRepositoryInterface;
use Executor\Manager\Domain\Services\CommandManagerServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;
use Shared\Infrastructure\Events\Subscribe;

#[Subscribe(event: ExecuteCommand::EXECUTE_COMMAND_EVENT)]
class ExecuteCommandHandler implements CommandHandlerInterface, ShouldQueue
{
    private ExternalCommandRepositoryInterface $repository;
    private CommandManagerServiceInterface $service;
    
    public function __construct(ExternalCommandRepositoryInterface $repository, CommandManagerServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service    = $service;
    }
    
    public function handle(ExecuteCommand|CommandInterface $command): ? CommandResponseInterface
    {
        $externalCommand = $command->getExternalCommand();
        if ($externalCommand->hasNotBeenCompleted()) {
            $this->service->execute($externalCommand);
            $this->repository->update($externalCommand);
        }
        return null;
    }
}
