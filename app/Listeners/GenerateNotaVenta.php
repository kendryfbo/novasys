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

        // Creacion de Archivo PDF
        $notaVenta->load('detalle','cliente.region:id,descripcion','centroVenta');
        $pdf = PDF::loadView('documents.pdf.ordenDespacho',compact('notaVenta'));
        // $pdf->save('Nota_Venta_'.$notaVenta->numero.'.pdf');
        $path = 'public/notas_ventas/nota_venta_'.$notaVenta->numero.'v'.$notaVenta->version.'.pdf';
        Storage::disk('local')->put($path,$pdf);
        // Generacion de Mail
        Mail::to('soporte@novafoods.cl')
        ->send(new NewNotaVenta($notaVenta));
    }
}
