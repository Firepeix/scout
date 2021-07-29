<?php


namespace Lancelot\Pulse\Infrastructure\Persistence\Models;


use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
    protected $connection = 'grail';
    protected $table = 'report_card';
    
}
