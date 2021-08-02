<?php

namespace Lancelot\Context\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class FieldModel extends Model
{
    protected $connection = 'grail';
    protected $table = 'metabase_field';
    
}
