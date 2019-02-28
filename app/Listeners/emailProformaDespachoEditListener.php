<?php

namespace App\Listeners;

use Mail;
use App\Mail\MailProformaDespachoEdit;
use App\Events\AuthorizedProformaEditEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class emailProformaDespachoEditListener
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
    public function handle(AuthorizedProformaEditEvent $event)
    {
        $proforma = $event->proforma;

        Mail::send(new MailProformaDespachoEdit($proforma));
    }
}
