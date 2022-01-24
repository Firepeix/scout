<?php

namespace Shared\Infrastructure\Providers;

use Executor\Manager\Domain\CommandRouter;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event as EventProvider;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Shared\Infrastructure\Application\ApplicationCommand;
use Shared\Infrastructure\Events\Event;
use Shared\Infrastructure\Events\Subscribe;

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
        $this->registerEvents();
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
    
    private function registerEvents(): void
    {
        $events = $this->getEvents();
        foreach ($events as $event) {
            foreach (array_unique($event['listeners']) as $listener) {
                EventProvider::listen($event['event'], $listener);
            }
        }
    }
    
    private function getEvents(): array
    {
        $events = [];
        foreach ($this->commands as $command => $handler) {
            $checks = [$command => new ReflectionClass($command), $handler => new ReflectionClass($handler)];
            foreach ($checks as $class => $check) {
                $eventAttributes = $check->getAttributes(Event::class);
                foreach ($eventAttributes as $attribute) {
                    $attribute = $attribute->newInstance();
                    $events[$attribute->getEventName()]['event'] = $class;
                }
    
                $listenerAttributes = $check->getAttributes(Subscribe::class);
                foreach ($listenerAttributes as $attribute) {
                    $attribute = $attribute->newInstance();
                    $events[$attribute->getEventName()]['listeners'][] = $class;
                }
            }
        }
        
        return $events;
    }
}
