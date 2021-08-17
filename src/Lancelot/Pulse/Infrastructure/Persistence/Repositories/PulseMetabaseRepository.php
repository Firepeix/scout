<?php

namespace Lancelot\Pulse\Infrastructure\Persistence\Repositories;

use Illuminate\Support\Collection;
use Lancelot\Context\Domain\Context;
use Lancelot\Context\Domain\Repositories\ContextRepositoryInterface;
use Lancelot\Pulse\Domain\Pulse;
use Lancelot\Pulse\Domain\Repositories\PulseRepositoryInterface;
use Lancelot\Pulse\Domain\ValueObject\AlertCondition;
use Lancelot\Pulse\Domain\ValueObject\Name;
use Lancelot\Pulse\Domain\ValueObject\Query;
use Lancelot\Pulse\Domain\ValueObject\Report;
use Lancelot\Pulse\Domain\ValueObject\Reports;
use Lancelot\Pulse\Domain\ValueObject\SkipEmpty;
use Lancelot\Pulse\Infrastructure\Persistence\Models\PulseModel;
use Lancelot\Pulse\Infrastructure\Persistence\Models\ReportModel;

class PulseMetabaseRepository implements PulseRepositoryInterface
{
    private ContextRepositoryInterface $contextRepository;
    
    public function __construct(ContextRepositoryInterface $contextRepository)
    {
        $this->contextRepository = $contextRepository;
    }
    
    public function getActivePulses(): Collection
    {
        return PulseModel::with('reports')
            ->where('pulse.archived', false)
            ->get()
            ->map(fn (PulseModel $model) => $this->map($model));
    }
    
    private function map(PulseModel $model) : Pulse
    {
        $pulse = new Pulse(
            new Name($model->name),
            new SkipEmpty($model->skip_if_empty),
            new AlertCondition($model->alert_condition),
            new Reports($this->reportMaps($model->reports)),
        );
        
        if ($model->alert_above_goal === true) {
            $pulse->alertsAboveGoal();
        }
        
        return $pulse;
    }
    
    private function reportMaps(Collection $reports) : Collection
    {
        $tablesIds = $reports->map(fn ($report) => json_decode($report->dataset_query, true))
            ->pluck('query.source-table');
        $context = $this->contextRepository->buildContextFromTableIds($tablesIds);
        return $reports->map(fn (ReportModel $model) => $this->reportMap($model, $context));
    }
    
    private function reportMap(ReportModel $model, Context $context) : Report
    {
        $query = json_decode($model->dataset_query, true);
        $settings = json_decode($model->visualization_settings, true);
        return new Report(new Query($query, $context), $settings['graph.goal_value'] ?? null);
    }
}
