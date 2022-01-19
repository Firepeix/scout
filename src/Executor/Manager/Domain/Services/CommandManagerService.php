<?php

namespace Executor\Manager\Domain\Services;

use Executor\Manager\Domain\CommandRouter;
use Executor\Manager\Domain\Errors\ApplicationCommandNotFoundError;
use Executor\Manager\Domain\ExternalCommand;
use Illuminate\Contracts\Bus\Dispatcher;

class CommandManagerService implements CommandManagerServiceInterface
{
    private CommandRouter $router;
    private Dispatcher $dispatcher;
    
    public function __construct(CommandRouter $router, Dispatcher $dispatcher)
    {
        $this->router     = $router;
        $this->dispatcher = $dispatcher;
    }
    
    
    public function execute(ExternalCommand $command): void
    {
        if ($command->hasNotBeenCompleted()) {
            $name         = $command->getName()->value();
            $commandClass = $this->findCommand($name);
            $executor     = new $commandClass(...$command->getArgs());
            $payload      = $this->dispatcher->dispatch($executor);
        }
    }
    
    private function findCommand(string $name): string
    {
        return $this->router->getCommand($name)
            ->expect(new ApplicationCommandNotFoundError($name));
    }
    
    private function cleanCommand(ExternalCommand $command): void
    {
        #TODO adicionar logica de limpar comando
    }
}
