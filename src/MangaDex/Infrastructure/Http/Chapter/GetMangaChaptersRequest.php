<?php


namespace MangaDex\Infrastructure\Http\Chapter;


use App\Domain\Manga\SourcedVariation as Manga;
use MangaDex\Infrastructure\Http\MangaDexAbstractRequest;

class GetMangaChaptersRequest extends MangaDexAbstractRequest
{
    private const URI = 'chapter';
    private const METHOD = 'GET';
    
    private Manga $manga;
    
    public function __construct(Manga $manga)
    {
        parent::__construct(self::METHOD, self::URI);
        $this->manga = $manga;
    }
    
    protected function getQuery(): array
    {
        return [
            'manga' => $this->manga->getExternalId(),
            'translatedLanguage' => ['en'],
            'order' => [
                'chapter' => 'desc'
            ]
        ];
    }
    
    protected function createResponse(array $content): GetMangaChaptersResponse
    {
        return new GetMangaChaptersResponse($content);
    }
    
    public function execute(): GetMangaChaptersResponse
    {
        return parent::execute();
    }
}
