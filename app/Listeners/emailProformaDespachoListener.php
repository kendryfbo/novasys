<?php

namespace App\Listeners;

use Mail;
use App\Mail\MailProformaDespacho;
use App\Events\AuthorizedProformaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class emailProformaDespachoListener
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
     * @param  AuthorizedProformaEvent  $event
     * @return void
     */
    public function handle(AuthorizedProformaEvent $event)
    {
        $proforma = $event->proforma;

        Mail::send(new MailProformaDespacho($proforma));
    }
}
