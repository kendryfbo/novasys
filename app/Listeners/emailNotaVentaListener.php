<?php

namespace App\Listeners;


use Mail;
use App\Mail\MailNotaVenta;
use App\Events\AuthorizedNotaVentaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class emailNotaVentaListener
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
     * @param  AuthorizedNotaVentaEvent  $event
     * @return void
     */
    public function handle(AuthorizedNotaVentaEvent $event)
    {
        $notaVenta = $event->notaVenta;

        Mail::send(new MailNotaVenta($notaVenta));
    }
}
