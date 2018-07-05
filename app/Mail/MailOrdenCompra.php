<?php

namespace App\Mail;

use PDF;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Adquisicion\OrdenCompra;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailOrdenCompra extends Mailable
{
    use Queueable, SerializesModels;

    // propiedades publicas estan disponibles en la vista sin necesidad de importar
    public $ordenCompra;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrdenCompra $ordenCompra)
    {
        $this->ordenCompra = $ordenCompra;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ordenCompra = $this->ordenCompra;
        $numero = $ordenCompra->numero;
        $centroVenta = $this->ordenCompra->centroVenta;
        $fileName = 'ORDEN COMPRA '.$numero;
        $sender = Auth::user()->email;
        $receiver = 'soporte@novafoods.cl';
        $CC =$sender;
        $pdf = PDF::loadView('documents.pdf.ordenCompraPDF',compact('ordenCompra','centroVenta'));
        $this->markdown('emails.mailOrdenCompra')
                    ->subject($fileName)
                    ->from($sender)
                    ->to($receiver)
                    ->cc($CC)
                    ->attachData($pdf->download(), $fileName.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
        return $this->view('view.name');
    }
}
