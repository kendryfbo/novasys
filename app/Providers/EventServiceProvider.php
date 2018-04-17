<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\AuthorizedNotaVentaEvent' => [
            'App\Listeners\sendEmailOfAuthNotaVenta',
        ],
        'App\Events\CreateFacturaNacionalEvent' => [
            'App\Listeners\GenerateFacturaExcel',
        ],
        'App\Events\CreateProformaEvent' => [
            'App\Listeners\generateProformaMail',
        ],
        'App\Events\CreateFacturaIntlEvent' => [
            'App\Listeners\GenerateFacturaIntlExcel',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
