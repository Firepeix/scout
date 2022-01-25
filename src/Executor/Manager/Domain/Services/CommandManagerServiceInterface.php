<?php

namespace Executor\Manager\Domain\Services;

use Executor\Manager\Domain\ExternalCommand;

interface CommandManagerServiceInterface
{
    public function execute(ExternalCommand $command): void;
    public function shouldClean(ExternalCommand $command): bool;
    public function take(ExternalCommand $command): void;
}
