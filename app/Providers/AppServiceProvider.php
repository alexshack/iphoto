<?php

namespace App\Providers;

use App\Repositories\ExpensesTypeRepository;
use App\Repositories\IncomesTypeRepository;
use App\Repositories\Interfaces\ExpensesTypeRepositoryInterface;
use App\Repositories\Interfaces\IncomesTypeRepositoryInterface;
use App\Repositories\Interfaces\SalesTypeRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\SalesTypeRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SalesTypeRepositoryInterface::class, SalesTypeRepository::class);
        $this->app->bind(IncomesTypeRepositoryInterface::class, IncomesTypeRepository::class);
        $this->app->bind(ExpensesTypeRepositoryInterface::class, ExpensesTypeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
