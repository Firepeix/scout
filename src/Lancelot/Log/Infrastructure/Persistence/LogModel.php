<?php


namespace Lancelot\Log\Infrastructure\Persistence;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @method static mixed where(string $column, string $operator, mixed $value)
 */
class LogModel extends Model
{
    protected $connection = 'chest';
    protected $collection = 'logs';
}
