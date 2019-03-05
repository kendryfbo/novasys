<?php

namespace App\Mail;

use PDF;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Config\EnvioMail;
use App\Models\Comercial\Proforma;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class mailProformaDespachoEdit extends Mailable
{
    use Queueable, SerializesModels;

    public $proforma;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Proforma $proforma)
    {
        $this->proforma = $proforma;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $listaMails = EnvioMail::getMailListProformaDespacho();
        $recivers = [];
        foreach ($listaMails->detalles as $mail) {
            array_push($recivers, $mail->mail);
        }
        $proforma = $this->proforma;
        $numero = $proforma->numero;
        $version = $proforma->version;
        $fileName = 'MODIFICACIÓN ORDEN DESPACHO PROFORMA '.$numero. ' Versión '. $version;
        $sender = Auth::user()->email;
        //$bcc = $sender;
        $pdf = PDF::loadView('documents.pdf.proformaDespacho',['proforma' => $proforma]);
        $pdfFile = $pdf->download('PROFORMA '.$proforma->numero.'.pdf');
        return $this->markdown('emails.mailProformaEdit')
                    ->subject($fileName)
                    ->from($sender)
                    ->to($recivers)
                    //->bcc($bcc)
                    ->attachData($pdfFile, $fileName.'.pdf');
    }
}
