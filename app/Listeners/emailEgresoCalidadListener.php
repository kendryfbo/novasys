<?php

namespace App\Listeners;

use Mail;
use App\Mail\MailEgresoCalidad;
use App\Events\EgresoGeneratedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class emailEgresoCalidadListener
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
     * @param  EgresoGeneratedEvent  $event
     * @return void
     */
    public function handle(EgresoGeneratedEvent $event)
    {
        $egreso = $event->egreso;
        Mail::send(new MailEgresoCalidad($egreso));
    }
}
