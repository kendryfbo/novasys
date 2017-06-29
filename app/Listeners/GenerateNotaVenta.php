<?php

namespace App\Listeners;

use App\Events\AuthorizedNotaVentaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\NewNotaVenta;
use Mail;
use PDF;
use Storage;
class GenerateNotaVenta implements ShouldQueue
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

        $fileName = 'nota_venta_'.$numero.'v'.$version;
        $path = storage_path().'/app/public/notas_ventas/'.$fileName;
        
        // Creacion de Archivo PDF
        $pdf = PDF::loadView('documents.pdf.ordenDespacho',compact('notaVenta'));
        $pdf->save($path);

        // Generacion de Mail
        Mail::to('soporte@novafoods.cl')
        ->send(new NewNotaVenta($notaVenta));
    }
}
