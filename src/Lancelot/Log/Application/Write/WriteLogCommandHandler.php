<?php


namespace Lancelot\Log\Application\Write;


use Psr\Log\LoggerInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class WriteLogCommandHandler  implements CommandHandlerInterface
{
    private LoggerInterface $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function handle(WriteLogCommand|CommandInterface $command): ? CommandResponseInterface
    {
        $this->logger->info($command->getMessage(), $command->getContext());
        return null;
    }
}
