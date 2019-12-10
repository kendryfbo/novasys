<?php

namespace App\Models\Informes;

use DB;
use Illuminate\Database\Eloquent\Model;

class ventasMercado extends Model
{


  static function consultaVentaMesIntl($lastYear,$fechaSelected,$lastYearSelected,$yearSelected) {

    $consultaIntl = "SELECT a.cliente AS 'client', c.nombre AS 'country',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYear%' THEN a.fob ELSE NULL END) AS 'mesAnterior',
    SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.fob ELSE NULL END) AS 'mesActual',
    SUM(CASE WHEN (a.fecha_emision BETWEEN '$lastYearSelected-01-01 00:00:00' AND '$lastYear-31 23:59:59') THEN a.fob ELSE NULL END) AS 'acumuladoAnterior',
    SUM(CASE WHEN (a.fecha_emision BETWEEN '$yearSelected-01-01 00:00:00' AND '$fechaSelected-31 23:59:59') THEN a.fob ELSE NULL END) AS 'acumuladoActual'
    FROM factura_intl a, cliente_intl b, pais c WHERE a.cliente_id=b.id AND b.pais_id=c.id AND 1=1 GROUP BY a.cliente;";
    $ventaMesIntl = DB::select(DB::raw($consultaIntl));
    return $ventaMesIntl;
  }



  static function consultaVentaMesNovafoods($lastYear,$fechaSelected,$lastYearSelected,$yearSelected) {

    $consultaNacNovafoods = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$lastYear%' THEN a.neto ELSE NULL END) AS 'mesAnterior',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$lastYearSelected-01-01 00:00:00' AND '$lastYear-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoAnterior',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$yearSelected-01-01 00:00:00' AND '$fechaSelected-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '1' AND a.cliente_id NOT LIKE '79' AND a.cliente_id NOT LIKE '78' GROUP BY a.cv_id;";
    $ventaMesNovafoods = DB::select(DB::raw($consultaNacNovafoods));
    return $ventaMesNovafoods;
  }


  static function consultaVentaMesWalmart($lastYear,$fechaSelected,$lastYearSelected,$yearSelected) {

    $consultaNacWalmart = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$lastYear%' THEN a.neto ELSE NULL END) AS 'mesAnterior',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$lastYearSelected-01-01 00:00:00' AND '$lastYear-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoAnterior',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$yearSelected-01-01 00:00:00' AND '$fechaSelected-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '1' AND a.cliente_id LIKE '78' GROUP BY a.cv_id;";
    $ventaMesWalmart = DB::select(DB::raw($consultaNacWalmart));
    return $ventaMesWalmart;
  }


  static function consultaVentaMesRenova($lastYear,$fechaSelected,$lastYearSelected,$yearSelected) {

    $consultaNacRenova = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$lastYear%' THEN a.neto ELSE NULL END) AS 'mesAnterior',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$lastYearSelected-01-01 00:00:00' AND '$lastYear-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoAnterior',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$yearSelected-01-01 00:00:00' AND '$fechaSelected-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '1' AND a.cliente_id LIKE '79' GROUP BY a.cv_id;";
    $ventaMesRenova = DB::select(DB::raw($consultaNacRenova));
    return $ventaMesRenova;
  }


  static function consultaVentaMesMercaNacional($lastYear,$fechaSelected,$lastYearSelected,$yearSelected) {

    $consultaNacMercaNacional = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$lastYear%' THEN a.neto ELSE NULL END) AS 'mesAnterior',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$lastYearSelected-01-01 00:00:00' AND '$lastYear-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoAnterior',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$yearSelected-01-01 00:00:00' AND '$fechaSelected-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '3' AND 1=1 GROUP BY a.cv_id;";
    $ventaMesMercaNacional = DB::select(DB::raw($consultaNacMercaNacional));
    return $ventaMesMercaNacional;
  }


  static function consultaVentaMesSumarca($lastYear,$fechaSelected,$lastYearSelected,$yearSelected) {

    $consultaNacSumarca = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$lastYear%' THEN a.neto ELSE NULL END) AS 'mesAnterior',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$lastYearSelected-01-01 00:00:00' AND '$lastYear-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoAnterior',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$yearSelected-01-01 00:00:00' AND '$fechaSelected-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '2' AND 1=1 GROUP BY a.cliente;";
    $ventaMesSumarca = DB::select(DB::raw($consultaNacSumarca));
    return $ventaMesSumarca;
  }











}
