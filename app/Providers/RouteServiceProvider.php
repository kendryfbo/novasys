<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
         Route::group([
             'middleware' => 'web',
             'namespace' => $this->namespace,
         ], function ($router) {

             require base_path('routes/web.php');
         });

         Route::group([
             'middleware' => ['web','auth'],
             'namespace' => $this->namespace,
         ], function ($router) {

             require base_path('routes/desarrollo.php');
             require base_path('routes/comercial.php');
             require base_path('routes/bodega.php');
             require base_path('routes/produccion.php');
             require base_path('routes/operaciones.php');
             require base_path('routes/finanzas.php');
             require base_path('routes/adquisicion.php');
             require base_path('routes/config.php');
         });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        // Route::prefix('api')
        //      ->middleware('api')
        //      ->namespace($this->namespace)
        //      ->group(base_path('routes/api.php'));
         Route::group([
             'middleware' => 'api',
             'prefix' => 'api',
             'namespace' => $this->namespace,
         ], function ($router) {

             require base_path('routes/api.php');
             require base_path('routes/apiDesarrollo.php');
             require base_path('routes/apiComercial.php');
             require base_path('routes/apiBodega.php');
         });
    }
}
