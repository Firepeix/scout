<?php

namespace Lancelot\Pulse\Domain;

use Illuminate\Support\Collection;
use Lancelot\Pulse\Domain\ValueObject\AlertCondition;
use Lancelot\Pulse\Domain\ValueObject\Name;
use Lancelot\Pulse\Domain\ValueObject\Reports;
use Lancelot\Pulse\Domain\ValueObject\SkipEmpty;
use Lancelot\Pulse\Domain\ValueObject\StopOnAny;

class Pulse
{
    private const ROWS_CONDITION = 'rows';
    
    private Name           $name;
    private SkipEmpty      $skipEmpty;
    private AlertCondition $alertCondition;
    private StopOnAny      $alertFirstOnly;
    private Reports        $reports;
    
    public function __construct(Name $name, SkipEmpty $skipEmpty, AlertCondition $alertCondition, StopOnAny $alertFirstOnly, Reports $reports)
    {
        $this->name           = $name;
        $this->skipEmpty      = $skipEmpty;
        $this->alertCondition = $alertCondition;
        $this->alertFirstOnly = $alertFirstOnly;
        $this->reports        = $reports;
    }
    
    
    public function shouldFire(): bool
    {
        foreach ($this->reports as $report) {
            $check = $this->check($report->retrieve());
            if ($check) {
                if (self::ROWS_CONDITION === $this->alertCondition->value()) {
                    return true;
                }
                continue;
            }
            
            if (self::ROWS_CONDITION !== $this->alertCondition->value()) {
                return false;
            }
            
        }
        
        return true;
    }
    
    private function check(Collection $rows) : bool
    {
    
    }
    
    
}
