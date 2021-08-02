<?php

namespace Lancelot\Context\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TableModel extends Model
{
    protected $connection = 'grail';
    protected $table = 'metabase_table';
    
    public function fields() : HasMany
    {
        return $this->hasMany(FieldModel::class, 'table_id');
    }
    
    public function database() : BelongsTo
    {
        return $this->belongsTo(DatabaseModel::class, 'db_id');
    }
}
