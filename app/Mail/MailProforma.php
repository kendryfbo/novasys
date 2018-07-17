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

class MailProforma extends Mailable
{
    use Queueable, SerializesModels;

    // propiedades publicas estan disponibles en la vista sin necesidad de importar
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
        $envioID = EnvioMail::proformaMailID();
        $listaMails = EnvioMail::with('detalles')->where('id',$envioID)->first();
        $recivers = [];
        foreach ($listaMails->detalles as $mail) {
            array_push($recivers, $mail->mail);
        }
        $proforma = $this->proforma;
        $numero = $proforma->numero;
        $version = $proforma->version;
        $fileName = 'PRUEBA - PROFORMA '.$numero. ' Versión '. $version;
        $sender = Auth::user()->email;
        $bcc =$sender;
        $pdf = PDF::loadView('documents.pdf.proforma',['proforma' => $proforma]);
        $pdfFile = $pdf->download('PROFORMA '.$proforma->numero.'.pdf');
        return $this->markdown('emails.mailProforma')
                    ->subject($fileName)
                    ->from($sender)
                    ->to($recivers)
                    ->bcc($bcc)
                    ->attachData($pdfFile, $fileName.'.pdf');
    }
}
