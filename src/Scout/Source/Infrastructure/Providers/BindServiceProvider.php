<?php


namespace Scout\Source\Infrastructure\Providers;


use Illuminate\Support\ServiceProvider;
use Scout\Source\Domain\SourceRepository;
use Scout\Source\Infrastructure\Persistence\SourceRepository as SourceRepositoryConcrete;

class BindServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(SourceRepository::class, SourceRepositoryConcrete::class);
    }
}
