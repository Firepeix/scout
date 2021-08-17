<?php

namespace Shared\UI\App;

use Illuminate\Routing\Router;

abstract class AbstractRoute
{
    protected array $options;
    protected Router $router;
    
    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->router = app()->make(Router::class);
    }
    
    public function register()
    {
        $this->router->group($this->options, fn () => $this->routes());
    }
    
    protected abstract function routes();
    
}
