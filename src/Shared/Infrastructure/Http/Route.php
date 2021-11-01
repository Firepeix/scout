<?php

namespace Shared\Infrastructure\Http;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Route
{
    private string $url;
    private string $method;
    private string $name;
    
    public function __construct(string $url, string $method, string $name = null)
    {
        $this->url    = $url;
        $this->method = $method;
        $this->name   = $name ?? "$url-$method";
    }
    
    public function getUrl(): string
    {
        return $this->url;
    }
    
    public function getMethod(): string
    {
        return $this->method;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
}
