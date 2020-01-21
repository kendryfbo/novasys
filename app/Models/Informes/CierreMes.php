<?php

namespace App\Models\Informes;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CierreMes extends Model
{

  static function cierreMesIntl($request) {

    $actualYearFilter = false;
    $lastYearFilter = false;
    $previousYearFilter = false;

    if ($request->filter) {

      $actualYearFilter = isset($request->actualYear) ? true : false;
      $lastYearFilter = isset($request->lastYear) ? true : false;
      $previousYearFilter = isset($request->previousYear) ? true : false;
    } else {

      $actualYearFilter = true;
      $lastYearFilter = true;
      $previousYearFilter = true;
    }

    $now = Carbon::now();
    $currentYear = $now->year;
    $lastYear = $now->year-1;
    $previousYear = $now->year-2;

    $user = '968730908';
    $password = 'hrE36pwNK64Lp12';
    $wsdl = 'https://si3.bcentral.cl/sietews/sietews.asmx?wsdl';

    $seriesIds = array("F073.TCO.PRE.Z.D");
    $firstDate = Carbon::now()->format('Y-m-d');
    $lastDate =  Carbon::now()->format('Y-m-d');
    $client = new soapclient($wsdl);
    $params = new \stdClass();
    $params->user = $user;
    $params->password = $password;
    $params->firstDate = $firstDate;
    $params->lastDate = $lastDate;
    $params->seriesIds = $seriesIds;

    $result = $client->GetSeries($params)->GetSeriesResult;
    $fameSeries = $result->Series->fameSeries;
    $valorDolar = $fameSeries->obs->value;

    if ($actualYearFilter) {

      $queryCurrentYear = "SELECT MONTH(a.fecha_emision) AS month_number, SUM(a.fob) AS total FROM factura_intl a WHERE YEAR(a.fecha_emision)=".$currentYear." GROUP BY MONTH(a.fecha_emision)";
      $resultsCurrentYear = DB::select(DB::raw($queryCurrentYear));

      $queryCurrentYearNac = "SELECT MONTH(a.fecha_emision) AS month_number, SUM(a.neto) AS total FROM factura_nacional a WHERE YEAR(a.fecha_emision)=".$currentYear." GROUP BY MONTH(a.fecha_emision)";
      $resultsCurrentYearNac = DB::select(DB::raw($queryCurrentYearNac));
    }
    if ($lastYearFilter) {

      $queryLastYear = "SELECT MONTH(a.fecha_emision) AS month ,SUM(a.fob) AS total FROM factura_intl a WHERE YEAR(a.fecha_emision)=".$lastYear." GROUP BY MONTH(a.fecha_emision)";
      $resultsLastYear = DB::select(DB::raw($queryLastYear));

      $queryLastYearNac = "SELECT MONTH(a.fecha_emision) AS month ,SUM(a.neto) AS total FROM factura_nacional a WHERE YEAR(a.fecha_emision)=".$lastYear." GROUP BY MONTH(a.fecha_emision)";
      $resultsLastYearNac = DB::select(DB::raw($queryLastYearNac));
    }
    if ($previousYearFilter) {

      $queryPreviousYear = "SELECT MONTH(a.fecha_emision) AS month ,SUM(a.fob) AS total FROM factura_intl a WHERE YEAR(a.fecha_emision)=".$previousYear." GROUP BY MONTH(a.fecha_emision)";
      $resultsPreviousYear = DB::select(DB::raw($queryPreviousYear));

      $queryPreviousYearNac = "SELECT MONTH(a.fecha_emision) AS month ,SUM(a.neto) AS total FROM factura_nacional a WHERE YEAR(a.fecha_emision)=".$previousYear." GROUP BY MONTH(a.fecha_emision)";
      $resultsPreviousYearNac = DB::select(DB::raw($queryPreviousYearNac));
    }
    $queryProjections = "SELECT MONTH,a.amount AS total FROM presup_intl_detalles a WHERE a.presupuesto_id=(SELECT id FROM presupuesto_intl WHERE presupuesto_intl.year=".$currentYear." ORDER BY id DESC LIMIT 1)";
    $resultsProjections = DB::select(DB::raw($queryProjections));

    $queryProjectionsNac = "SELECT MONTH,a.amount AS total FROM presup_nac_detalles a WHERE a.presupuesto_id=(SELECT id FROM presupuesto_nac WHERE presupuesto_nac.year=".$currentYear." ORDER BY id DESC LIMIT 1)";
    $resultsProjectionsNac = DB::select(DB::raw($queryProjectionsNac));


    $arrayData = [];
    $arrayMonths = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

    array_push($arrayData,['Mes','Año '.$currentYear,'Año '.$lastYear,'Año '.$previousYear,'Proyeccion']);

    for ($i=0; $i<=11;$i++) {

      $month = isset($arrayMonths[$i])  ? $arrayMonths[$i] : 'Desconocido';
      $current = isset($resultsCurrentYear[$i])  ? ($resultsCurrentYear[$i]->total + ($resultsCurrentYearNac[$i]->total / $valorDolar)): 0;
      $last = isset($resultsLastYear[$i])  ? ($resultsLastYear[$i]->total + ($resultsLastYearNac[$i]->total / $valorDolar)) : 0;
      $previous = isset($resultsPreviousYear[$i])  ? ($resultsPreviousYear[$i]->total + ($resultsPreviousYearNac[$i]->total / $valorDolar)) : 0;
      $proj = isset($resultsProjections[$i])  ? ($resultsProjections[$i]->total + $resultsProjectionsNac[$i]->total): 0;

      array_push($arrayData,[$month,$current,$last,$previous,$proj]);
    }
    //dd($arrayData);
    return $arrayData;
  }
}
