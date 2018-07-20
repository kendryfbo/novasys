<?php

namespace App\Mail;

use PDF;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Config\EnvioMail;
use App\Models\Comercial\NotaVenta;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class mailNotaVenta extends Mailable
{
    use Queueable, SerializesModels;

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
        $listaMails = EnvioMail::getMailListNotaVenta();
        $recivers = [];
        foreach ($listaMails->detalles as $mail) {
            array_push($recivers, $mail->mail);
        }

        $notaVenta = $this->notaVenta;
        $numero = $notaVenta->numero;
        $version = $notaVenta->version;
        $fileName = 'PRUEBA - NOTA VENTA '.$numero. ' Versión '. $version;
        $sender = Auth::user()->email;
        //$bcc = $sender;
        $pdf = PDF::loadView('documents.pdf.notaVenta',['notaVenta' => $notaVenta]);
        $pdfFile = $pdf->download('NOTA VENTA '.$notaVenta->numero.'.pdf');
        return $this->markdown('emails.mailNotaVenta')
                    ->subject($fileName)
                    ->from($sender)
                    ->to($recivers)
                    //->bcc($bcc)
                    ->attachData($pdfFile, $fileName.'.pdf');
    }
}
