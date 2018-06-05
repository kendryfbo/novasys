<?php

namespace App\Listeners;

use PDF;
use Mail;
use Storage;
use App\Mail\NewNotaVenta;

use App\Events\AuthorizedNotaVentaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class sendEmailOfAuthNotaVenta //implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AuthorizedNotaVentaEvent  $event
     * @return void
     */
    public function handle(AuthorizedNotaVentaEvent $event)
    {
        $notaVenta = $event->notaVenta;

        $notaVenta->load('detalle','cliente.region:id,descripcion','centroVenta');
        $numero = $notaVenta->numero;
        $version = $notaVenta->version;

        // Generacion de Mail
        Mail::to('soporte@novafoods.cl')
        ->send(new NewNotaVenta($notaVenta));
    }
}
