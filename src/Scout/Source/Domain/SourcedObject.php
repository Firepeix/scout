<?php


namespace Scout\Source\Domain;


use Scout\Source\Domain\ValueObject\Type;
use Shared\Domain\ValueObject\Id;
use Shared\Domain\ValueObject\StringValueObject;

interface SourcedObject
{
    public function getType() : Type;
    
    public function getExternalId() : Id;
    
    public function getName() : StringValueObject;
}
