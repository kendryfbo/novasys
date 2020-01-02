<?php

namespace App\Models\Informes;

use DB;
use App\Models\Comercial\NotaCreditoNac;
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

  static function consultaFacturasIntl($fechaSelected) {

    $consultaIntl = "SELECT a.cliente AS 'client', a.fecha_emision, a.fob, a.proforma, a.centro_venta, a.numero, a.cliente, c.nombre AS 'country'
    FROM factura_intl a, cliente_intl b, pais c WHERE a.cliente_id=b.id AND b.pais_id=c.id AND 1=1 AND a.fecha_emision LIKE '%$fechaSelected%' GROUP BY a.cliente;";
    $facturasMensualesIntl = DB::select(DB::raw($consultaIntl));
    return $facturasMensualesIntl;
  }

  static function consultaTotalFacturasIntl($fechaSelected) {

    $consultaIntl = "SELECT SUM(fob) as 'mesActual' FROM factura_intl WHERE fecha_emision LIKE '%$fechaSelected%';";
    $totalFacturasMensualesIntl = DB::select(DB::raw($consultaIntl));
    return $totalFacturasMensualesIntl;
  }

  static function consultaTotalFacturasNac($fechaSelected) {

    $consultaNac = "SELECT SUM(neto) as 'mesActual' FROM factura_nacional WHERE fecha_emision LIKE '%$fechaSelected%';";
    $totalFacturasMensualesNac = DB::select(DB::raw($consultaNac));
    return $totalFacturasMensualesNac;
  }

  static function consultaVentaMesNovafoods($lastYear,$fechaSelected,$lastYearSelected,$yearSelected) {

  $consultaNacNovafoods = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$lastYear%' THEN a.neto ELSE NULL END) AS 'mesAnterior',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$lastYearSelected-01-01 00:00:00' AND '$lastYear-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoAnterior',
         SUM(CASE WHEN (a.fecha_emision BETWEEN '$yearSelected-01-01 00:00:00' AND '$fechaSelected-31 23:59:59') THEN a.neto ELSE NULL END) AS 'acumuladoActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '1' AND a.cliente_id NOT LIKE '78' AND a.cliente_id NOT LIKE '79' GROUP BY a.cv_id;";
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

    // Sólo a Mercado Nacional se le aplicaron las Notas de Crédito para restar a las facturas

    $notaCredNacLastYear = NotaCreditoNac::where('fecha', 'like', '%'.$lastYear.'%')->sum("neto");
    $notaCredNacActual = NotaCreditoNac::where('fecha', 'like', '%'.$fechaSelected.'%')->sum("neto");
    $lastDescNotaCreditoNac = NotaCreditoNac::whereBetween('fecha', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("neto");
    $descNotaCreditoNac = NotaCreditoNac::whereBetween('fecha',[''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("neto");

    $consultaNacMercaNacional = "SELECT
        a.cliente AS 'client',
         (SUM(CASE WHEN a.fecha_emision LIKE '%$lastYear%' THEN a.neto ELSE NULL END) - $notaCredNacLastYear) AS 'mesAnterior',
         (SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) - $notaCredNacActual)  AS 'mesActual',
         (SUM(CASE WHEN (a.fecha_emision BETWEEN '$lastYearSelected-01-01 00:00:00' AND '$lastYear-31 23:59:59') THEN a.neto ELSE NULL END) - $lastDescNotaCreditoNac) AS 'acumuladoAnterior',
         (SUM(CASE WHEN (a.fecha_emision BETWEEN '$yearSelected-01-01 00:00:00' AND '$fechaSelected-31 23:59:59') THEN a.neto ELSE NULL END) - $descNotaCreditoNac) AS 'acumuladoActual'
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

  static function cierreMesNovafoods($fechaSelected) {

    $consultaNacNovafoods = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '1' AND a.cliente_id NOT LIKE '79' AND a.cliente_id NOT LIKE '78' GROUP BY a.cv_id;";
    $cierreMesNovafoods = DB::select(DB::raw($consultaNacNovafoods));
    return $cierreMesNovafoods;
  }


  static function cierreMesWalmart($fechaSelected) {

    $consultaNacWalmart = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '1' AND a.cliente_id LIKE '78' GROUP BY a.cv_id;";
    $cierreMesWalmart = DB::select(DB::raw($consultaNacWalmart));
    return $cierreMesWalmart;
  }


  static function cierreMesRenova($fechaSelected) {

    $consultaNacRenova = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '1' AND a.cliente_id LIKE '79' GROUP BY a.cv_id;";
    $cierreMesRenova = DB::select(DB::raw($consultaNacRenova));
    return $cierreMesRenova;
  }


  static function cierreMesMercaNacional($fechaSelected) {

    // Sólo a Mercado Nacional se le aplicaron las Notas de Crédito para restar a las facturas

    $notaCredNacActual = NotaCreditoNac::where('fecha', 'like', '%'.$fechaSelected.'%')->sum("neto");

    $consultaNacMercaNacional = "SELECT
        a.cliente AS 'client',
         (SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) - $notaCredNacActual) AS 'mesActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '3' AND 1=1 GROUP BY a.cv_id;";
    $cierreMesMercaNacional = DB::select(DB::raw($consultaNacMercaNacional));
    return $cierreMesMercaNacional;
  }


  static function cierreMesSumarca($fechaSelected) {

    $consultaNacSumarca = "SELECT
        a.cliente AS 'client',
         SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.neto ELSE NULL END) AS 'mesActual'
          FROM factura_nacional a, cliente_nacional b WHERE a.cliente_id=b.id AND a.cv_id = '2' AND 1=1 GROUP BY a.cliente;";
    $cierreMesSumarca = DB::select(DB::raw($consultaNacSumarca));
    return $cierreMesSumarca;
  }

  static function consultaProyeccionIntlEnero($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '1';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacEnero($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '1';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlFebrero($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '2';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacFebrero($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '2';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlMarzo($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '3';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacMarzo($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '3';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlAbril($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '4';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacAbril($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '4';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlMayo($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '5';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacMayo($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '5';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlJunio($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '6';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacJunio($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '6';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlJulio($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '7';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacJulio($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '7';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlAgosto($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '8';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacAgosto($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '8';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlSeptiembre($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '9';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacSeptiembre($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '9';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlOctubre($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '10';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacOctubre($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '10';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlNoviembre($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '11';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacNoviembre($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '11';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function consultaProyeccionIntlDiciembre($currentYear) {

    $consultaProyeccionIntl = "SELECT amount from presupuesto_intl a, presup_intl_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '12';";
    $proyeccionIntl = DB::select(DB::raw($consultaProyeccionIntl));
    return $proyeccionIntl;
  }

  static function consultaProyeccionNacDiciembre($currentYear) {

    $consultaProyeccionNac = "SELECT amount from presupuesto_nac a, presup_nac_detalles b WHERE a.id=b.presupuesto_id AND a.year = '$currentYear' AND b.month = '12';";
    $proyeccionNac = DB::select(DB::raw($consultaProyeccionNac));
    return $proyeccionNac;
  }

  static function reportePorContenedor($dateSelected) {

    $yearToFind = $dateSelected;
    $lastYearToFind = $yearToFind - 1;

    $consultaReportPorContenedor = "SELECT a.cliente,
    SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-01%' THEN b.volumen ELSE NULL END) AS 'mesEnero',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-01%' THEN b.volumen ELSE NULL END) AS 'mesEneroAnt',
    SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-02%' THEN b.volumen ELSE NULL END) AS 'mesFebrero',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-02%' THEN b.volumen ELSE NULL END) AS 'mesFebreroAnt',
    SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-03%' THEN b.volumen ELSE NULL END) AS 'mesMarzo',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-03%' THEN b.volumen ELSE NULL END) AS 'mesMarzoAnt',
    SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-04%' THEN b.volumen ELSE NULL END) AS 'mesAbril',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-04%' THEN b.volumen ELSE NULL END) AS 'mesAbrilAnt',
    SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-05%' THEN b.volumen ELSE NULL END) AS 'mesMayo',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-05%' THEN b.volumen ELSE NULL END) AS 'mesMayoAnt',
	  SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-06%' THEN b.volumen ELSE NULL END) AS 'mesJunio',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-06%' THEN b.volumen ELSE NULL END) AS 'mesJunioAnt',
 	  SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-07%' THEN b.volumen ELSE NULL END) AS 'mesJulio',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-07%' THEN b.volumen ELSE NULL END) AS 'mesJulioAnt',
	  SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-08%' THEN b.volumen ELSE NULL END) AS 'mesAgosto',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-08%' THEN b.volumen ELSE NULL END) AS 'mesAgostoAnt',
	  SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-09%' THEN b.volumen ELSE NULL END) AS 'mesSeptiembre',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-09%' THEN b.volumen ELSE NULL END) AS 'mesSeptiembreAnt',
	  SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-10%' THEN b.volumen ELSE NULL END) AS 'mesOctubre',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-10%' THEN b.volumen ELSE NULL END) AS 'mesOctubreAnt',
	  SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-11%' THEN b.volumen ELSE NULL END) AS 'mesNoviembre',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-11%' THEN b.volumen ELSE NULL END) AS 'mesNoviembreAnt',
	  SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected-12%' THEN b.volumen ELSE NULL END) AS 'mesDiciembre',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind-12%' THEN b.volumen ELSE NULL END) AS 'mesDiciembreAnt',
    SUM(CASE WHEN a.fecha_emision LIKE '%$dateSelected%' THEN (b.volumen / 20) ELSE NULL END) AS 'totalYearSelected',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYearToFind%' THEN (b.volumen / 20) ELSE NULL END) AS 'totalLastYear'
    FROM factura_intl a, fact_intl_detalles b WHERE a.id=b.factura_id GROUP BY a.cliente;";
    $reportPorContenedor = DB::select(DB::raw($consultaReportPorContenedor));
    return $reportPorContenedor;
  }


  static function consultaFacturasIntlPorPais($lastYear,$fechaSelected,$lastYearSelected,$yearSelected) {

    $consultaIntl = "SELECT a.cliente AS 'client', c.nombre AS 'country',
    SUM(CASE WHEN a.fecha_emision LIKE '%$lastYear%' THEN a.fob ELSE NULL END) AS 'mesAnterior',
    SUM(CASE WHEN a.fecha_emision LIKE '%$fechaSelected%' THEN a.fob ELSE NULL END) AS 'mesActual',
    SUM(CASE WHEN (a.fecha_emision BETWEEN '$lastYearSelected-01-01 00:00:00' AND '$lastYear-31 23:59:59') THEN a.fob ELSE NULL END) AS 'acumuladoAnterior',
    SUM(CASE WHEN (a.fecha_emision BETWEEN '$yearSelected-01-01 00:00:00' AND '$fechaSelected-31 23:59:59') THEN a.fob ELSE NULL END) AS 'acumuladoActual'
    FROM factura_intl a, cliente_intl b, pais c WHERE a.cliente_id=b.id AND b.pais_id=c.id AND 1=1 GROUP BY c.id;";
    $ventaMesIntl = DB::select(DB::raw($consultaIntl));
    return $ventaMesIntl;
  }




}
