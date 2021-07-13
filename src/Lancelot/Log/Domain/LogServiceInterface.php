<?php


namespace Lancelot\Log\Domain;


use Illuminate\Support\Collection;

interface LogServiceInterface
{
    public function alertShouldBeNecessary(Collection $logs) : void;
}
