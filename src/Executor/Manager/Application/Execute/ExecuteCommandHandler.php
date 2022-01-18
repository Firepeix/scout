<?php

namespace Executor\Manager\Application\Execute;

use Executor\Manager\Domain\Repositories\ExternalCommandRepositoryInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class ExecuteCommandHandler  implements CommandHandlerInterface
{
    private ExternalCommandRepositoryInterface $repository;
    
    public function __construct(ExternalCommandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function handle(ExecuteCommand|CommandInterface $command): ? CommandResponseInterface
    {
        $commands = $this->repository->getExternalCommands();
        return null;
    }
}
