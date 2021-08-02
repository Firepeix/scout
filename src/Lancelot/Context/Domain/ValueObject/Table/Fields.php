<?php


namespace Lancelot\Context\Domain\ValueObject\Table;

use Closure;
use Illuminate\Support\Collection;
use Lancelot\Context\Domain\ValueObject\Field\Field;

class Fields extends Collection
{
    private Collection $hash;
    public function __construct($items = [])
    {
        parent::__construct($items);
        $this->hash = $this->hash(fn (Field $field) => $field->getId());
    }
    
    public function hash(Closure $keyBy) : Collection
    {
        $clone = new Collection($this->items);
        return $clone->keyBy($keyBy);
    }
    
    public function findById(int $id) : Field
    {
        $field = $this->first(function (Field $field) use ($id) {
            return $field->hasId($id);
        });
        $field->setParent($this->hash);
        return $field;
    }
}

