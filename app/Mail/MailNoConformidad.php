<?php

namespace App\Mail;

use PDF;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Calidad\Noconformidad;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailNoConformidad extends Mailable
{
    use Queueable, SerializesModels;
    // propiedades publicas estan disponibles en la vista sin necesidad de importar
    public $noConformidad;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Noconformidad $noConformidad)
    {
        $this->noConformidad = $noConformidad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $noConformidad = $this->noConformidad;
        $noConf_id  = $noConformidad->id;
        $fileName = 'No Conformidad '.$noConf_id;
        $sender = Auth::user()->email;
        $receiver = explode(';', $noConformidad->para->email);

        $CC = $sender;
        //$pdf = PDF::loadView('documents.pdf.calidad.noconformidadPDF',['noConformidad' => $noconformidad]);
        //$pdfFile = $pdf->download('No Conformidad '.$noconformidad->id.'.pdf');
        return $this->markdown('emails.mailNoConformidad')
                    ->subject($fileName)
                    ->from($sender)
                    ->to($receiver)
                    ->cc($CC);
                    //->attachData($pdfFile, $fileName.'.pdf');
    }
}
