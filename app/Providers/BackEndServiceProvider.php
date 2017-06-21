<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackEndServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Comercial\NotaVenta::Observe(\App\Observers\NotaVentaObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Comercial\NotaVenta\NotaVentaRepositoryInterface', 'App\Repositories\Comercial\NotaVenta\NotaVentaRepository');
    }
}
