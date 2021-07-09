<?php


namespace Shared\Domain\Bus;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command) : ?CommandResponseInterface;
}
