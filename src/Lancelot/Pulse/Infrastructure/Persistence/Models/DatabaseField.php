<?php


namespace Lancelot\Pulse\Infrastructure\Persistence\Models;


use Illuminate\Database\Eloquent\Model;

class DatabaseField extends Model
{
    protected $connection = 'grail';
    protected $table = 'pulse_card';
}
