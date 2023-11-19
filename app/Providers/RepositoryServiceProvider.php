<?php

namespace App\Providers;

use App\Contracts\Cuenta\CuentaRepositoryInterface;
use App\Contracts\Cuenta\PedidoRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\EloquentCuentaRepository;
use App\Repositories\EloquentPedidoRepository;

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

        $this->app->bind(
            PedidoRepositoryInterface::class,
            EloquentPedidoRepository::class
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
