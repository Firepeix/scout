<?php

namespace Lancelot\Pulse\Domain;

use Illuminate\Support\Collection;
use Lancelot\Pulse\Domain\ValueObject\AlertAboveGoal;
use Lancelot\Pulse\Domain\ValueObject\AlertCondition;
use Lancelot\Pulse\Domain\ValueObject\Name;
use Lancelot\Pulse\Domain\ValueObject\Report;
use Lancelot\Pulse\Domain\ValueObject\Reports;
use Lancelot\Pulse\Domain\ValueObject\SkipEmpty;

class Pulse
{
    private const ROWS_CONDITION = 'rows';
    private const GOAL_CONDITION = 'goal';
    
    private Name           $name;
    private SkipEmpty      $skipEmpty;
    private AlertCondition $alertCondition;
    private Reports        $reports;
    private AlertAboveGoal $alertAboveGoal;
    
    public function __construct(Name $name, SkipEmpty $skipEmpty, AlertCondition $alertCondition, Reports $reports)
    {
        $this->name           = $name;
        $this->skipEmpty      = $skipEmpty;
        $this->alertCondition = $alertCondition;
        $this->reports        = $reports;
        $this->alertAboveGoal = new AlertAboveGoal();
    }
    
    public function alertsAboveGoal() : void
    {
        $this->alertAboveGoal = new AlertAboveGoal(true);
    }
    
    
    public function shouldFire(): bool
    {
        $conditions = [
            self::ROWS_CONDITION => fn (Collection $rows, Report $report) => $this->checkRowsCondition($rows),
            self::GOAL_CONDITION => fn (Collection $rows, Report $report) => $this->checkGoalCondition($rows, $report)
        ];
        
        if (isset($conditions[$this->alertCondition->value()])) {
            foreach ($this->reports as $report) {
                $rows = $report->retrieve();
                if ($this->skipEmpty->value() && $rows->isEmpty()) {
                    return false;
                }
    
                return $conditions[$this->alertCondition->value()]($rows, $report);
            }
        }
        
    
        return false;
    }
    
    private function checkRowsCondition(Collection $rows) : bool
    {
        return $rows->isNotEmpty();
    }
    
    private function checkGoalCondition(Collection $rows, Report $report) : bool
    {
        $goal = $report->getGoal();
        $current = $rows->count();
        return $this->alertAboveGoal->value() ? $current >= $goal : $current <= $goal;
    }
    
    public function getName(): string
    {
        return $this->name->value();
    }
}
