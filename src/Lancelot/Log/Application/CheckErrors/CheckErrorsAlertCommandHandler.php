<?php


namespace Lancelot\Log\Application\CheckErrors;

use Carbon\Carbon;
use Lancelot\Log\Domain\LogRepositoryInterface;
use Lancelot\Log\Domain\LogServiceInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

final class CheckErrorsAlertCommandHandler implements CommandHandlerInterface
{
    private LogRepositoryInterface $repository;
    private LogServiceInterface $service;
    
    public function __construct(LogRepositoryInterface $repository, LogServiceInterface $service)
    {
        $this->service = $service;
        $this->repository = $repository;
    }
    
    public function handle(CheckErrorsAlert|CommandInterface $command): ? CommandResponseInterface
    {
        $logs        = $this->repository->getErrorLogsSince(Carbon::now()->subHours(3));
        $this->service->alertShouldBeNecessary($logs);
        return null;
    }
}
