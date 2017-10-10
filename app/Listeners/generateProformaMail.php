<?php

namespace App\Listeners;

use App\Events\CreateProformaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class generateProformaMail
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
     * @param  CreateProformaEvent  $event
     * @return void
     */
    public function handle(CreateProformaEvent $event)
    {
        //
    }
}
