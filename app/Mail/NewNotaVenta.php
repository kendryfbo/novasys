<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Comercial\NotaVenta;

class NewNotaVenta extends Mailable
{
    use Queueable, SerializesModels;

    // propiedades publicas estan disponibles en la vista sin necesidad de importar
    public $notaVenta;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(NotaVenta $notaVenta)
    {
        $this->notaVenta = $notaVenta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $numero = $this->notaVenta->numero;
        $version = $this->notaVenta->version;
        $path = public_path().'/Nota_Venta_'.$numero.'.pdf';

        return $this
        ->markdown('emails.newNotaVenta')
        ->subject('Nota de Venta '.$numero.' version Nº '.$version)
        ->attach($path, [
                       'as' => 'Nota_Venta_'.$numero.'.pdf',
                       'mime' => 'application/pdf',
                   ]);
    }
}
