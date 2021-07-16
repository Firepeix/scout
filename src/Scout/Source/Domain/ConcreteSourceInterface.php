<?php


namespace Scout\Source\Domain;


use Illuminate\Support\Collection;

interface ConcreteSourceInterface
{
    public function getLastUpdate(SourcedObject $object) : string;
    
    public function getFollowedSourcedObjects() : Collection;
    
    public function toArray() : array;
}
