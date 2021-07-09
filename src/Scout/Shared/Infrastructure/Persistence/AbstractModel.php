<?php


namespace Scout\Shared\Infrastructure\Persistence;


use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @method static find(string $id)
 * @method static Collection where(string $string, int|null $value)
 */
class AbstractModel extends Model
{

}
