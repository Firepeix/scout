<?php


namespace MangaDex\Infrastructure\Http\Chapter;


use MangaDex\Infrastructure\Http\MangaDexAbstractRequest;
use Scout\Source\Domain\SourcedObject;

class GetMangaChaptersRequest extends MangaDexAbstractRequest
{
    private const URI = 'chapter';
    private const METHOD = 'GET';
    
    private SourcedObject $manga;
    
    public function __construct(SourcedObject $manga)
    {
        parent::__construct(self::METHOD, self::URI);
        $this->manga = $manga;
    }
    
    protected function getQuery(): array
    {
        return [
            'manga' => (string) $this->manga->getSourcedId(),
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
