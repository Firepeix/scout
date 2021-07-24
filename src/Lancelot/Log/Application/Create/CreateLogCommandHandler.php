<?php


namespace Lancelot\Log\Application\Create;


use Lancelot\Log\Domain\LogRepositoryInterface;
use Lancelot\Log\Domain\LogServiceInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class CreateLogCommandHandler  implements CommandHandlerInterface
{
    private LogRepositoryInterface $repository;
    private LogServiceInterface $service;
    
    public function __construct(LogRepositoryInterface $repository, LogServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service    = $service;
    }
    
    public function handle(CreateLogCommand|CommandInterface $command): ? CommandResponseInterface
    {
        $this->repository->insert($command->getLog());
        return null;
    }
}
