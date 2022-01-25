<?php


namespace Lancelot\Log\Domain;


use Illuminate\Support\Collection;

interface LogServiceInterface
{
    public function alertShouldBeNecessary(Collection $logs) : void;
    
    public function sendToNewRelic(array $log) : void;
    public function format(array $log) : array;
}
