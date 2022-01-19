<?php

namespace Shared\Infrastructure\Providers;

use Executor\Manager\Domain\CommandRouter;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Shared\Infrastructure\Application\ApplicationCommand;

abstract class AbstractBusServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, string>
     */
    protected array $commands = [];
    
    public function boot(): void
    {
        $this->registerHandlers();
    }
    
    public function register(): void
    {
        $this->registerCommandRoutes();
    }
    
    private function registerHandlers()
    {
        Bus::map($this->commands);
    }
    
    private function registerCommandRoutes(): void
    {
        $router = $this->app->make(CommandRouter::class);
        foreach ($this->commands as $command => $handler) {
            $reflection = new ReflectionClass($command);
            $attributes = $reflection->getAttributes(ApplicationCommand::class);
            foreach ($attributes as $attribute) {
                $attribute = $attribute->newInstance();
                $router->addCommand($attribute->getName(), $command);
            }
        }
    }
}
