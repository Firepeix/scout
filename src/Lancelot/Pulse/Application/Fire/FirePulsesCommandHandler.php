<?php


namespace Lancelot\Pulse\Application\Fire;


use Lancelot\Pulse\Domain\Repositories\PulseRepositoryInterface;
use Lancelot\Pulse\Domain\Services\PulseServiceInterface;
use Lancelot\Pulse\UI\Console\FirePulses;
use Psr\Log\LoggerInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class FirePulsesCommandHandler  implements CommandHandlerInterface
{
    private LoggerInterface $logger;
    private PulseRepositoryInterface $repository;
    private PulseServiceInterface $service;
    
    public function __construct(LoggerInterface $logger, PulseRepositoryInterface $repository, PulseServiceInterface $service)
    {
        $this->logger     = $logger;
        $this->repository = $repository;
        $this->service    = $service;
    }
    
    public function handle(FirePulses|CommandInterface $command): ? CommandResponseInterface
    {
        $this->logger->info('Iniciando disparo dos pulsos');
        $this->service->fire($this->repository->getActivePulses());
        $this->logger->info('Terminado disparo dos pulsos');
        return null;
    }
}
