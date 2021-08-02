<?php


namespace Lancelot\Context\Domain\Repositories;

use Illuminate\Support\Collection;
use Lancelot\Context\Domain\Context;

interface ContextRepositoryInterface
{
    public function buildContextFromTableIds(Collection $tableIds) : Context;
}
