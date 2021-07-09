<?php


namespace Scout\Source\Domain;

use Illuminate\Support\Collection;

interface SourceInterface
{
    public function getFollowedSourcedObjects() : Collection;
}
