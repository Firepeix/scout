<?php


namespace MangaDex\Infrastructure\Http\User\Manga;


use MangaDex\Infrastructure\Http\MangaDexAbstractRequest;

class GetUserMangaRequest extends MangaDexAbstractRequest
{
    private const URI    = 'user/follows/manga';
    private const METHOD = 'GET';
    
    private int $limit;
    private int $offset;
    
    public function __construct(int $limit = 100, int $offset = 0)
    {
        parent::__construct(self::METHOD, self::URI);
        $this->limit  = $limit;
        $this->offset = $offset;
    }
    
    protected function getQuery(): array
    {
        return [
            'limit'  => $this->limit,
            'offset' => $this->offset
        ];
    }
    
    protected function createResponse(array $content): GetUserMangaResponse
    {
        return new GetUserMangaResponse($content);
    }
    
    public function execute(): GetUserMangaResponse
    {
        return parent::execute();
    }
    
    
}
