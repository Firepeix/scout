<?php

namespace Lancelot\Pulse\Infrastructure\Persistence\Repositories;

use Illuminate\Support\Collection;
use Lancelot\Pulse\Domain\Pulse;
use Lancelot\Pulse\Domain\Repositories\PulseRepositoryInterface;
use Lancelot\Pulse\Domain\ValueObject\AlertCondition;
use Lancelot\Pulse\Domain\ValueObject\Name;
use Lancelot\Pulse\Domain\ValueObject\Report;
use Lancelot\Pulse\Domain\ValueObject\Report\Query;
use Lancelot\Pulse\Domain\ValueObject\Reports;
use Lancelot\Pulse\Domain\ValueObject\SkipEmpty;
use Lancelot\Pulse\Domain\ValueObject\StopOnAny;
use Lancelot\Pulse\Infrastructure\Persistence\Models\PulseModel;
use Lancelot\Pulse\Infrastructure\Persistence\Models\ReportModel;

class PulseMetabaseRepository implements PulseRepositoryInterface
{
    public function getActivePulses(): Collection
    {
        return PulseModel::with('reports')
            ->where('pulse.archived', false)
            ->get()
            ->map(fn (PulseModel $model) => $this->map($model));
    }
    
    private function map(PulseModel $model) : Pulse
    {
        return new Pulse(
            new Name($model->name),
            new SkipEmpty($model->skip_if_empty),
            new AlertCondition($model->alert_condition),
            new StopOnAny($model->alert_first_only),
            new Reports($model->reports->map(fn (ReportModel $model) => $this->reportMap($model))),
        );
    }
    
    private function reportMap(ReportModel $model) : Report
    {
        return new Report(new Query($model->dataset_query));
    }
}
