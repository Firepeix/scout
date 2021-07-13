<?php


namespace Lancelot\Log\Application\Clean;


use Lancelot\Log\Domain\LogRepositoryInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class CleanLogsCommandHandler  implements CommandHandlerInterface
{
    private LogRepositoryInterface $repository;
    
    public function __construct(LogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function handle(CleanLogsCommand|CommandInterface $command): ? CommandResponseInterface
    {
        $this->repository->cleanLogs();
        return null;
    }
}
