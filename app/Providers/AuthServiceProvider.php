<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('gerencia',function($user,$acceso = NULL){
            //$permiso = $user->role->permisos
            //                ->where('descripcion',$acceso)
            //                ->pluck('acceso')->first();
            //dd(session('accesos')[$acceso]);
            return (session('accesos')[$acceso]);
            //return $permiso;
        });
    }
}
