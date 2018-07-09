<?php

namespace App\Mail;

use PDF;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Adquisicion\OrdenCompra;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailOrdenCompra extends Mailable implements ShouldQueue
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
        $fileName = 'ORDEN COMPRA '.$numero;
        $sender = 'soporte@novafoods.cl';//Auth::user()->email;
        $receiver = 'soporte@novafoods.cl';
        $CC =$sender;
        $pdf = PDF::loadView('documents.pdf.ordenCompraPDF',['ordenCompra' => $ordenCompra]);
        $pdfFile = $pdf->download('Orden Compra Nº'.$ordenCompra->numero.'.pdf');
        return $this->markdown('emails.mailOrdenCompra')
                    ->subject($fileName)
                    ->from($sender)
                    ->to($receiver)
                    ->cc($CC)
                    ->attachData($pdfFile, $fileName.'.pdf');
    }
}
