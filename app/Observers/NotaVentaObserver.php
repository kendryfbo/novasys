<?php

namespace App\Observers;
use App\Comercial\Models\NotaVenta;
use App\Events\AuthorizedNotaVentaEvent;

class NotaVentaObserver
{
	public function authorized($notaVenta) {

		event(new AuthorizedNotaVentaEvent($notaVenta));
	}
}
