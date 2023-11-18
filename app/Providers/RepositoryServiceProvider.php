<?php

namespace App\Providers;

use App\Contracts\Cuenta\CuentaRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\EloquentCuentaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CuentaRepositoryInterface::class,
            EloquentCuentaRepository::class
        );
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
