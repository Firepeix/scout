<?php


namespace Scout\Source\Domain;


use Scout\Source\Domain\ValueObject\Type;
use Shared\Domain\ValueObject\Id;
use Shared\Domain\ValueObject\StringValueObject;

interface SourcedObject
{
    public function getSourcedType() : Type;
    
    public function getSourcedId() : Id;
    
    public function getSourcedName() : StringValueObject;
}
