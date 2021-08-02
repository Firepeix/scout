<?php

namespace Lancelot\Context\Domain\ValueObject\Field;

use Illuminate\Support\Collection;

class Field
{
    public const DESCRIPTOR = 'field';
    
    private Id $id;
    private Name $name;
    private ? ParentId $parentId;
    private ? Field $parent = null;
    
    public function __construct(Id $id, Name $name, ?ParentId $parentId)
    {
        $this->id       = $id;
        $this->name     = $name;
        $this->parentId = $parentId;
    }
    
    public function hasId(int $id) : bool
    {
        return $this->id->equals(new Id($id));
    }
    
    public function getContextFieldName(string $childName = ''): string
    {
        if ($this->parent === null) {
            return trim("{$this->name->value()}.$childName", '.');
        }
        return $this->parent->getContextFieldName("{$this->name->value()}.$childName");
    }
    
    public function getId(): int
    {
        return $this->id->value();
    }
    
    public function setParent(Collection $hashedFields) : void
    {
        if ($this->parentId !== null) {
            $parent = $hashedFields[$this->parentId->value()] ?? null;
            if ($parent !== null) {
                $parent->setParent($hashedFields);
                $this->parent = $parent;
            }
        }
    }
}
