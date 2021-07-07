<?php

namespace MangaDex\Infrastructure\Http\Authorization;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository as CacheContract;

class Authorizer
{
    private const BEARER_TOKEN_KEY = 'MANGADEX_TOKEN';
    private const BEARER_SESSION_TOKEN_KEY = 'MANGADEX_SESSION_TOKEN';
    private const AUTH_ENDPOINT = '/auth/login';
    private const RENEW_ENDPOINT = '/auth/refresh';
    
    private CacheContract $cache;
    public function __construct()
    {
        $this->cache = app(CacheContract::class);
    }
    
    public function getBearerToken() : string
    {
        if (!$this->hasStoredToken()) {
            if (!$this->hasSessionToken()) {
                $this->createBearerToken($this->requestTokens());
                return $this->getStoredToken();
            }
            $this->createBearerToken($this->renewBearerToken());
            return $this->getStoredToken();
        }
        return $this->getStoredToken();
    }
    
    private function getStoredToken() : string
    {
        return $this->cache->get(self::BEARER_TOKEN_KEY, null);
    }
    
    private function hasStoredToken() : bool
    {
        return $this->cache->has(self::BEARER_TOKEN_KEY);
    }
    
    private function hasSessionToken() : bool
    {
        return $this->cache->has(self::BEARER_SESSION_TOKEN_KEY);
    }
    
    private function getSessionToken() : string
    {
        return $this->cache->get(self::BEARER_SESSION_TOKEN_KEY, null);
    }
    
    private function renewBearerToken() : array
    {
        $renewToken = $this->getSessionToken();
        $client = new Client(['base_uri' => config('mangadex.uri')]);
        $body = ['token' => $renewToken];
        $response = $client->post(self::RENEW_ENDPOINT, ['json' => $body]);
        return json_decode($response->getBody()->getContents(), true)['token'];
    }
    
    private function createBearerToken(array $tokens) : void
    {
        $this->cache->put(self::BEARER_TOKEN_KEY, $tokens['session'], Carbon::now()->addMinutes(14));
        $this->cache->put(self::BEARER_SESSION_TOKEN_KEY, $tokens['refresh'], Carbon::now()->addMonth());
    }
    
    private function requestTokens() : array
    {
        $client = new Client(['base_uri' => config('mangadex.uri')]);
        $body = ['username' => config('mangadex.username'), 'password' => config('mangadex.password')];
        $response = $client->post(self::AUTH_ENDPOINT, ['json' => $body]);
        return json_decode($response->getBody()->getContents(), true)['token'];
    }
}
