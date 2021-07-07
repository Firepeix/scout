<?php


namespace MangaDex\Infrastructure\Http;


use GuzzleHttp\Client;
use MangaDex\Infrastructure\Http\Authorization\Authorizer;

abstract class MangaDexAbstractRequest
{
    private Authorizer $authorizer;
    private Client     $client;
    private string     $method;
    private string     $uri;
    
    public function __construct(string $method, string $uri)
    {
        $this->authorizer = new Authorizer();
        $this->client     = new Client(['base_uri' => config('mangadex.uri')]);
        $this->uri        = $uri;
        $this->method     = $method;
    }
    
    public function execute(): mixed
    {
        $options  = [
            'json'    => $this->getBody(),
            'query' => $this->getQuery(),
            'headers' => ["Authorization Bearer {$this->authorizer->getBearerToken()}"]
        ];
        $response = $this->client->request($this->method, $this->uri, $options);
        return $this->createResponse(json_decode($response->getBody()->getContents(), true));
    }
    
    protected function getBody(): array
    {
        return [];
    }
    
    protected function getQuery(): array
    {
        return [];
    }
    
    abstract protected function createResponse(array $content): mixed;
}
