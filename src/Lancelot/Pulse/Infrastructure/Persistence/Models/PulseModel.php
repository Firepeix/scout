<?php


namespace Lancelot\Pulse\Infrastructure\Persistence\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class PulseModel extends Model
{
    protected $connection = 'grail';
    protected $table = 'pulse';
    
    public function reports() : HasManyThrough
    {
        return $this->hasManyThrough(ReportModel::class, PulseReportModel::class, 'pulse_id', 'id', 'id', 'card_id');
    }
}
