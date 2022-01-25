<?php


namespace Lancelot\Log\Infrastructure\Http\NewRelic;

use GuzzleHttp\Client;

abstract class NewRelicRequest
{
    private Client     $client;
    private string     $method;
    private string     $uri;
    
    public function __construct(string $method, string $uri)
    {
        $this->client     = new Client([
            'base_uri' => config('services.new-relic.domain'),
            'headers' => ['X-License-Key' => config('services.new-relic.key')]
        ]);
        
        $this->uri        = $uri;
        $this->method     = $method;
    }
    
    public function execute(): mixed
    {
        $options  = [
            'json'    => $this->getBody(),
            'query' => $this->getQuery(),
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
