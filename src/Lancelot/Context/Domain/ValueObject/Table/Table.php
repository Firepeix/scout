<?php

namespace Lancelot\Context\Domain\ValueObject\Table;

class Table
{
    private Id $id;
    private Name $name;
    private Fields $fields;

    public function __construct(Id $id, Name $name, Fields $fields)
    {
        $this->id     = $id;
        $this->name   = $name;
        $this->fields = $fields;
    }
    
    public function hasId(int $id) : bool
    {
        return $this->id->equals(new Id($id));
    }
    
    public function getName() : string
    {
        return $this->name->value();
    }
    
    public function getFields(): Fields
    {
        return $this->fields;
    }
}
