<?php

namespace Shared\Domain\Bus;

use Closure;
use Illuminate\Bus\Dispatcher as BaseDispatcher;
use Illuminate\Contracts\Bus\Dispatcher as DispatcherInterface;
use Illuminate\Contracts\Container\Container;
use Lancelot\Log\Application\Clean\CleanLogsCommand;
use Lancelot\Log\Application\Create\CreateLogCommand;
use Lancelot\Log\Application\Write\WriteLogCommand;
use Psr\Log\LoggerInterface;

class Dispatcher extends BaseDispatcher implements DispatcherInterface
{
    private LoggerInterface $logger;
    
    public function __construct(Container $container, Closure $queueResolver = null)
    {
        parent::__construct($container, $queueResolver);
        $this->logger = app(LoggerInterface::class);
    }
    
    public function dispatchNow($command, $handler = null)
    {
        if ($command instanceof CleanLogsCommand || $command instanceof WriteLogCommand || $command instanceof CreateLogCommand) {
            return parent::dispatchNow($command, $handler);
        }
    
        if ($command instanceof CommandInterface) {
            $this->logger->info('Comando Iniciado', ['Comando' => get_class($command)]);
            $response = parent::dispatchNow($command, $handler);
            $this->logger->info('Comando Finalizado', ['Comando' => get_class($command)]);
            return $response;
        }
        
        return parent::dispatchNow($command, $handler);
    }
    
    public function dispatchToQueue($command)
    {
        if ($command instanceof CleanLogsCommand || $command instanceof WriteLogCommand || $command instanceof CreateLogCommand) {
            return parent::dispatchToQueue($command);
        }
        if ($command instanceof CommandInterface) {
            $this->logger->info('Comando Disparado', ['Comando' => get_class($command)]);
        }
        return parent::dispatchToQueue($command);
    }
}
