<?php

namespace Executor\Manager\Application\Dispatch;

use Exception;
use Executor\Manager\Application\Execute\ExecuteCommand;
use Executor\Manager\Domain\ExternalCommand;
use Executor\Manager\Domain\Repositories\ExternalCommandRepositoryInterface;
use Executor\Manager\Domain\Services\CommandManagerServiceInterface;
use Psr\Log\LoggerInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class DispatchCommandsCommandHandler  implements CommandHandlerInterface
{
    private ExternalCommandRepositoryInterface $repository;
    private LoggerInterface $logger;
    private CommandManagerServiceInterface $service;
    
    public function __construct(ExternalCommandRepositoryInterface $repository, LoggerInterface $logger, CommandManagerServiceInterface $service)
    {
        $this->repository = $repository;
        $this->logger     = $logger;
        $this->service    = $service;
    }
    
    public function handle(DispatchCommands|CommandInterface $command): ? CommandResponseInterface
    {
        while (true) {
            try {
                $commands = $this->repository->getExternalCommands();
                $commands->each(function (ExternalCommand $command) {
                    if (!$command->isLocked()) {
                        if ($command->shouldLock()) {
                            $this->service->take($command);
                            $this->repository->update($command);
                        }
                        dump("Dispatching {$command->getName()}");
                        event(new ExecuteCommand($command));
                    }
                });
            } catch (Exception $exception) {
                $this->logger->error("Error no loop de comando", ['exception' => $exception]);
            }
            sleep(20);
        }
    }
}
