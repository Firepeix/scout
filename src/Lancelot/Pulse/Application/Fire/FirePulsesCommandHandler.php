<?php


namespace Lancelot\Pulse\Application\Fire;


use Lancelot\Pulse\Domain\Repositories\PulseRepositoryInterface;
use Lancelot\Pulse\Domain\Services\PulseServiceInterface;
use Lancelot\Pulse\UI\Console\FirePulses;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class FirePulsesCommandHandler  implements CommandHandlerInterface
{
    private PulseRepositoryInterface $repository;
    private PulseServiceInterface $service;
    
    public function __construct(PulseRepositoryInterface $repository, PulseServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service    = $service;
    }
    
    public function handle(FirePulses|CommandInterface $command): ? CommandResponseInterface
    {
        $this->service->fire($this->repository->getActivePulses());
        return null;
    }
}
