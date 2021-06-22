<?php

namespace App\Providers;

use App\Repositories\Concretes\DirectoryRepository;
use App\Repositories\Concretes\HomologationRepository;
use App\Repositories\Interfaces\DirectoryRepositoryInterface;
use App\Repositories\Interfaces\HomologationRepositoryInterface;
use App\Services\Concretes\BuildService;
use App\Services\Concretes\HomologationService;
use App\Services\Interfaces\BuildServiceInterface;
use App\Services\Interfaces\HomologationServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        //
    }
}
