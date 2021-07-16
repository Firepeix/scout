<?php


namespace Scout\Source\Domain;

use Illuminate\Support\Collection;
use Scout\Source\Domain\ValueObject\SourceId;
use Scout\Source\Domain\ValueObject\Type;

interface SourceInterface
{
    public function getFollowedSourcedObjects() : Collection;
    
    public function getId() : SourceId;
    
    public function getType() : Type;
    
    public function getLastUpdate(SourcedObject $object) : string;
    
    public function toArray() : array;
}
