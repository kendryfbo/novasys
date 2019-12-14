<?php

namespace App\Models\Informes;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CierreMes extends Model
{

  static function cierreMesIntl() {

    $now = Carbon::now();
    $currentYear = $now->year;
    $lastYear = $now->year-1;

    $queryCurrentYear = "SELECT MONTH(a.fecha_emision) AS month_number,SUM(a.total) AS total FROM factura_intl a WHERE YEAR(a.fecha_emision)=".$currentYear." GROUP BY MONTH(a.fecha_emision)";
    $queryLastYear = "SELECT MONTH(a.fecha_emision) AS month ,SUM(a.total) AS total FROM factura_intl a WHERE YEAR(a.fecha_emision)=".$lastYear." GROUP BY MONTH(a.fecha_emision)";
    $queryProjections = "SELECT MONTH,a.amount AS total FROM presup_intl_detalles a WHERE a.presupuesto_id=(SELECT id FROM presupuesto_intl WHERE presupuesto_intl.year=".$currentYear." ORDER BY id DESC LIMIT 1)";

    $resultsCurrentYear = DB::select(DB::raw($queryCurrentYear));
    $resultsLastYear = DB::select(DB::raw($queryLastYear));
    $resultsProjectios = DB::select(DB::raw($queryProjections));

    $arrayData = [];
    $arrayMonths = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

    array_push($arrayData,['Mes','Año '.$currentYear,'Año '.$lastYear,'Proyeccion']);

    for ($i=0; $i<=11;$i++) {

      $month = isset($arrayMonths[$i])  ? $arrayMonths[$i] : 'Desconocido';
      $current = isset($resultsCurrentYear[$i])  ? $resultsCurrentYear[$i]->total: 0;
      $last = isset($resultsLastYear[$i])  ? $resultsLastYear[$i]->total : 0;
      $proj = isset($resultsProjectios[$i])  ? $resultsProjectios[$i]->total : 0;

      array_push($arrayData,[$month,$current,$last,$proj]);
    }

    return $arrayData;
  }
}
