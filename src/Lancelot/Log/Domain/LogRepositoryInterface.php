<?php


namespace Lancelot\Log\Domain;


use Carbon\Carbon;
use Illuminate\Support\Collection;

interface LogRepositoryInterface
{
    public function getErrorLogsSince(Carbon $carbon) : Collection;
    
    public function cleanLogs() : void;
}
