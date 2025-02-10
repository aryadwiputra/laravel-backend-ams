<?php

namespace App\Providers;

use App\Repositories\Categories\CategoryRepositoryInterface;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
