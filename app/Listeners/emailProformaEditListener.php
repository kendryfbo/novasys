<?php

namespace App\Listeners;

use Mail;
use App\Mail\MailProformaEdit;
use App\Events\AuthorizedProformaEditEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class emailProformaEditListener
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
     * @param  AuthorizedProformaEditEvent  $event
     * @return void
     */
    public function handle(AuthorizedProformaEditEvent $event)
    {
        $proforma = $event->proforma;

        Mail::send(new MailProformaEdit($proforma));
    }


}
