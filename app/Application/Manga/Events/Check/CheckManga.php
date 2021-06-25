<?php


namespace App\Application\Manga\Events\Check;


use App\Domain\Manga\Manga;
use Illuminate\Support\Facades\Event;

class CheckManga extends Event
{
    private Manga $manga;
    
    public function __construct(Manga $manga)
    {
        $this->manga = $manga;
    }
    
    public function getManga(): Manga
    {
        return $this->manga;
    }
    
}
