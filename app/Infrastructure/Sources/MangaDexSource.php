<?php

namespace App\Infrastructure\Sources;

use App\Domain\Manga\SourcedVariation;
use App\Domain\Sources\MangaSource;
use MangaDex\Infrastructure\Http\Chapter\GetMangaChaptersRequest;

class MangaDexSource extends AbstractSource implements MangaSource
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
}
