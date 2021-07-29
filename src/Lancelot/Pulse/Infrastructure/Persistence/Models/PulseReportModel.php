<?php


namespace Lancelot\Pulse\Infrastructure\Persistence\Models;


use Illuminate\Database\Eloquent\Model;

class PulseReportModel extends Model
{
    protected $connection = 'grail';
    protected $table = 'pulse_card';
}
