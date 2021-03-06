<?php

namespace Shared\Infrastructure;

use Illuminate\Bus\BatchFactory;
use Illuminate\Bus\BatchRepository;
use Illuminate\Bus\DatabaseBatchRepository;
use Illuminate\Contracts\Bus\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Bus\QueueingDispatcher as QueueingDispatcherContract;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Shared\Domain\Bus\Dispatcher;

class BusServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Dispatcher::class, function ($app) {
            return new Dispatcher($app, function ($connection = null) use ($app) {
                return $app[QueueFactoryContract::class]->connection($connection);
            });
        });
        
        $this->registerBatchServices();
        
        $this->app->alias(
            Dispatcher::class, DispatcherContract::class
        );
        
        $this->app->alias(
            Dispatcher::class, QueueingDispatcherContract::class
        );
    }
    
    /**
     * Register the batch handling services.
     *
     * @return void
     */
    protected function registerBatchServices()
    {
        $this->app->singleton(BatchRepository::class, DatabaseBatchRepository::class);
        
        $this->app->singleton(DatabaseBatchRepository::class, function ($app) {
            return new DatabaseBatchRepository(
                $app->make(BatchFactory::class),
                $app->make('db')->connection(config('queue.batching.database')),
                config('queue.batching.table', 'job_batches')
            );
        });
    }
    
    public function provides() : array
    {
        return [
            Dispatcher::class,
            DispatcherContract::class,
            QueueingDispatcherContract::class,
            BatchRepository::class,
        ];
    }
}
