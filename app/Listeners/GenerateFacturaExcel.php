<?php

namespace App\Listeners;

use App\Events\CreateFacturaNacionalEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;
use Excel;

class GenerateFacturaExcel
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
     * @param  CreateFacturaNacionalEvent  $event
     * @return void
     */
    public function handle(CreateFacturaNacionalEvent $event)
    {
        $facturaNacional = $event->facturaNacional;
        $fileName = 'Factura_'.$facturaNacional->numero;
        $excel = Excel::create($fileName, function($excel)
        {
            $excel->sheet('FirstSheet', function($sheet)
            {
                $sheet->loadView('documents.excel.facturaNacional');
            });
        });

        $path = '/app/public/facturas_nacionales/';
        $excel->store('xls', storage_path($path));
    }
}
