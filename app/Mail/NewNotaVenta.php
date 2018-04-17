<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Comercial\NotaVenta;
use Storage;

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

        $fileName = 'nota_venta_'.$numero.'v'.$version;
        $path = '/public/notas_ventas/'.$fileName;

        // load pdf
        $pdf = Storage::get($path);

        return $this->markdown('emails.newNotaVenta')
                    ->subject('Nota de Venta '.$numero.' version Nº '.$version)
                    ->attachData($pdf, $fileName.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
                    // ->attach($path, ['as' => $fileName,'mime' => 'application/pdf',]);
    }
}
