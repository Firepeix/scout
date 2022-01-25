<?php


namespace Executor\Manager\Application\Execute;

use Executor\Manager\Domain\ExternalCommand;
use Shared\Domain\Bus\CommandInterface;
use Shared\Infrastructure\Events\Event;

#[Event(event: ExecuteCommand::EXECUTE_COMMAND_EVENT)]
class ExecuteCommand implements CommandInterface
{
    public const EXECUTE_COMMAND_EVENT = 'EXECUTE_COMMAND_EVENT';
    
    private ExternalCommand $externalCommand;
    
    public function __construct(ExternalCommand $externalCommand)
    {
        $this->externalCommand = $externalCommand;
    }
    
    public function getExternalCommand(): ExternalCommand
    {
        return $this->externalCommand;
    }
}
