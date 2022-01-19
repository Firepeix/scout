<?php

namespace Executor\Manager\Application\Execute;

use Executor\Manager\Domain\ExternalCommand;
use Executor\Manager\Domain\Repositories\ExternalCommandRepositoryInterface;
use Executor\Manager\Domain\Services\CommandManagerServiceInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class ExecuteCommandHandler  implements CommandHandlerInterface
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
        $commands = $this->repository->getExternalCommands();
        $commands->each(function (ExternalCommand $command) {
            //TODO adicionar async
            $this->service->execute($command);
        });
        
        return null;
    }
}
