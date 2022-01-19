<?php

namespace Executor\Manager\Domain\Services;

use Exception;
use Executor\Manager\Domain\CommandRouter;
use Executor\Manager\Domain\Errors\ApplicationCommandNotFoundError;
use Executor\Manager\Domain\ExternalCommand;
use Executor\Manager\Domain\ValueObject\Body;
use Executor\Manager\Domain\ValueObject\ResponseCode;
use Illuminate\Contracts\Bus\Dispatcher;
use Shared\Domain\Util\Option\None;
use Shared\Domain\Util\Option\Option;
use Shared\Domain\Util\Option\Some;

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
            try {
                $name         = $command->getName()->value();
                $commandClass = $this->findCommand($name);
                $executor     = new $commandClass(...$command->getArgs());
                $payload      = $this->dispatcher->dispatch($executor);
                $this->completeWithSuccess($command, $payload !== null ? new Some($payload) : new None());
            } catch (Exception $exception) {
                $this->completeWithError($command, $exception->getMessage());
            }
            return;
        }
    }
    
    private function completeWithSuccess(ExternalCommand $command, Option $response): void
    {
        $command->complete(ResponseCode::success(), Body::success($response->unwrapOr([])->getData()));
    }
    
    private function completeWithError(ExternalCommand $command, string $error): void
    {
        $command->complete(ResponseCode::error(), Body::error($error));
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
