<?php

namespace App\Listeners;

use Excel;
use App\Events\CreateFacturaIntlEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateFacturaIntlExcel //implements ShouldQueue
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
     * @param  CreateFacturaIntlEvent  $event
     * @return void
     */
    public function handle(CreateFacturaIntlEvent $event)
    {
      $factura = $event->factura;

      return Excel::create('New file', function($excel) use ($factura) {
        $excel->sheet('New sheet', function($sheet) use ($factura) {
          $sheet->loadView('documents.excel.facturaIntl')
                ->with('factura', $factura);
          })->download('xlsx');
      });
      
    }
}
