<?php

namespace Lancelot\Context\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class DatabaseModel extends Model
{
    protected $connection = 'grail';
    protected $table = 'metabase_database';
}
