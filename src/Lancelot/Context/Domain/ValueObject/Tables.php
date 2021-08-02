<?php

namespace Lancelot\Context\Domain\ValueObject;

use Illuminate\Support\Collection;
use Lancelot\Context\Domain\ValueObject\Table\Table;

class Tables extends Collection
{
    public function findById(int $id) : Table
    {
        return $this->first(function (Table $table) use ($id) {
            return $table->hasId($id);
        });
    }
}
