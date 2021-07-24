<?php


namespace Lancelot\Log\Infrastructure\Persistence;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Lancelot\Log\Domain\Log;
use Lancelot\Log\Domain\LogInterface;
use Lancelot\Log\Domain\LogRepositoryInterface;
use Lancelot\Log\Domain\ValueObject\Id;

class LogRepository implements LogRepositoryInterface
{
    private LogModel $model;
    
    public function __construct(LogModel $model)
    {
        $this->model = $model;
    }
    
    protected function map(LogModel $model): LogInterface
    {
        return new Log(new Id($model->_id));
    }
    
    public function getErrorLogsSince(Carbon $carbon): Collection
    {
        return $this->model::where('@timestamp', '>', $carbon)
            ->where('level', Log::ERROR)->get()->map(fn (LogModel $model) => $this->map($model));
    }
    
    public function cleanLogs(): void
    {
        $errorsLogs = $this->model::where('level', '=', Log::ERROR)->get();
        $goodLogs = $this->model::where('@timestamp', '<', Carbon::now()->subWeek())->get();
        $errorsLogs->merge($goodLogs)->each(function (LogModel $model) {
            $model->delete();
        });
    }
    
    public function insert(array $log): void
    {
        $model = new LogModel();
        foreach ($log as $prop => $item) {
            $model->{$prop} = $item;
        }
        $model->{'@timestamp'} = Carbon::parse($log['@timestamp'])->subHours(3);
        $model->save();
    }
    
    
}
