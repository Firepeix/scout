<?php


namespace Scout\Book\Infrastructure\Providers;


use Illuminate\Support\ServiceProvider;
use Scout\Book\Domain\BookRepositoryInterface;
use Scout\Book\Domain\BookServiceInterface;
use Scout\Book\Domain\Services\BookService;
use Scout\Book\Infrastructure\Persistence\Repositories\GoogleSheetBookRepository;

class BindServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(BookServiceInterface::class, BookService::class);
        $this->app->bind(BookRepositoryInterface::class, GoogleSheetBookRepository::class);
    }
}
