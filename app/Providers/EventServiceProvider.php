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
            'App\Listeners\emailNotaVentaListener',
            'App\Listeners\emailNotaVentaDespachoListener',
        ],
        'App\Events\AuthorizedProformaEvent' => [
            'App\Listeners\emailProformaListener',
            'App\Listeners\emailProformaDespachoListener',
        ],
        'App\Events\EgresoGeneratedEvent' => [
            'App\Listeners\emailEgresoBodegaListener',
            'App\Listeners\emailEgresoCalidadListener',
        ],
        'App\Events\CreateFacturaNacionalEvent' => [
            'App\Listeners\GenerateFacturaExcel',
        ],
        'App\Events\CreateFacturaIntlEvent' => [
            'App\Listeners\GenerateFacturaIntlExcel',
        ],
        'App\Events\AuthorizedProformaEditEvent' => [
            'App\Listeners\emailProformaEditListener',
            'App\Listeners\emailProformaDespachoEditListener',
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
