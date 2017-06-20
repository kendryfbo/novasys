<?php

namespace App\Listeners;

use App\Events\NewNotaVentaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\NewNotaVenta;

class SendNotaVentaEmail implements ShouldQueue
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
     * @param  NewNotaVenta  $event
     * @return void
     */
    public function handle(NewNotaVentaEvent $event)
    {
        // $event->notaVenta OBJECT
         Mail::to('soporte@novafoods.cl')->send(new NewNotaVenta($event->notaVenta));

    }
}
