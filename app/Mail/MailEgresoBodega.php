<?php

namespace App\Mail;

use PDF;
use Auth;
use App\Models\Bodega\Egreso;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Config\EnvioMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailEgresoBodega extends Mailable
{
    use Queueable, SerializesModels;

    public $egreso;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Egreso $egreso)
    {
        $this->egreso = $egreso;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $listaMails = EnvioMail::getMailListEgresoBodega();
        $recivers = [];
        foreach ($listaMails->detalles as $mail) {
            array_push($recivers, $mail->mail);
        }
        $egreso = $this->egreso;
        $numero = $egreso->numero;
        $fileName = 'PRUEBA - ORDEN DESPACHO '.$numero;
        $sender = Auth::user()->email;
        //$bcc = $sender;
        $pdf = PDF::loadView('bodega.egreso.pdf',['egreso' => $egreso]);
        $pdfFile = $pdf->download('ORDEN EGRESO '.$egreso->numero.'.pdf');
        return $this->markdown('emails.mailEgresoBodega')
                    ->subject($fileName)
                    ->from($sender)
                    ->to($recivers)
                    //->bcc($bcc)
                    ->attachData($pdfFile, $fileName.'.pdf');
    }
}
