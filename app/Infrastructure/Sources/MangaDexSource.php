<?php

namespace App\Infrastructure\Sources;

use App\Domain\Manga\SourcedVariation;
use App\Domain\Sources\MangaSource;
use Illuminate\Support\Collection;
use MangaDex\Infrastructure\Http\Chapter\GetMangaChaptersRequest;
use MangaDex\Infrastructure\Http\User\Manga\GetUserMangaRequest;
use Scout\Source\Domain\ConcreteSourceInterface;
use Scout\Source\Domain\SourcedObject;

class MangaDexSource extends AbstractSource implements MangaSource, ConcreteSourceInterface
{
    public const TYPE = 3;
    
    public function __construct(int $type)
    {
        parent::__construct(config('mangadex.uri'), $type);
    }
    
    public function getLastChapter(SourcedVariation $manga): string
    {
        $request = new GetMangaChaptersRequest($manga);
        return $request->execute()->getLastChapterNumber();
    }
    
    public function belongsToSource(SourcedObject $object): bool
    {
        return false;
    }
    
    public function getLastUpdate(SourcedObject $object): string
    {
        return '';
    }
    
    public function getFollowedSourcedObjects(): Collection
    {
        $total  = 100;
        $offset = 0;
        $mangas = new Collection();
        while ($offset < $total) {
            $request  = new GetUserMangaRequest(100, $offset);
            $response = $request->execute();
            $mangas   = $mangas->merge($response->getMangas());
            $offset   = $offset + 100;
            $total    = $response->getTotalAvailable();
        }
        
        return $mangas;
    }
}
