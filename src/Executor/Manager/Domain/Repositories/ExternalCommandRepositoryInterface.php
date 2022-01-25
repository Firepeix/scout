<?php

namespace Executor\Manager\Domain\Repositories;

use Executor\Manager\Domain\ExternalCommand;
use Illuminate\Support\Collection;

interface ExternalCommandRepositoryInterface
{
    public function update(ExternalCommand $command) : void;
    
    public function delete(ExternalCommand $command) : void;
    
    /**
     * @return Collection<ExternalCommand>
     */
    public function getExternalCommands(): Collection;
}
