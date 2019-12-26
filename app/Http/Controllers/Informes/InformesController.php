<?php

namespace App\Http\Controllers\Informes;

use DB;
use Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mes;
use App\Models\Comercial\FacturaIntl;
use App\Models\Comercial\FacturaNacional;
use App\Models\Comercial\NotaCreditoNac;
use App\Models\Comercial\NotaCreditoIntl;
use App\Models\Informes\VentasMercado;
use App\Models\Informes\CierreMes;
use App\Models\Comercial\PresupuestoIntl;

class InformesController extends Controller
{
    public function main()
    {
      return view('informes.main');
	  }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
      $ventaMesIntl = [];
      $mesPasado = '';
      $mesActual = '';
      $sumaTotal = '';
      $sumaAnterior = '';
      $meses = Mes::getAll();
      $lastYearSelected = '';
      $yearSelected = '';
      $sumaAcumuladoTotal = '';
      $sumaAcumuladoAnterior = '';
      $ventaMesNovafoods = '';
      $ventaMesRenova = '';
      $ventaMesMercaNacional = '';
      $ventaMesSumarca = [];
      $sumaAnteriorNac = '';
      $sumaTotalNac = '';
      $sumaAcumuladoTotalNac = '';
      $sumaAcumuladoAnteriorNac = '';
      $busqueda = $request;

      //Data para gráfico
      $yearSelected = Carbon::now()->format('Y');
      $lastYearSelected = Carbon::now()->format('Y') - 1;
      $lastYearSelected = json_encode($lastYearSelected);

      $apiUrl = 'https://mindicador.cl/api';

            if ( ini_get('allow_url_fopen') ) {
              $json = file_get_contents($apiUrl);
            } else {

              $curl = curl_init($apiUrl);
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              $json = curl_exec($curl);
              curl_close($curl);
            }

      $dailyIndicators = json_decode($json);

      $valorDolar = $dailyIndicators->dolar->valor;

      $fechaSelected = $request->dateSelected;

      $lastYear = date('Y-m', strtotime('-1 year', strtotime($fechaSelected)));
      $mesActual = Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');

      $sumaTotal = FacturaIntl::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("fob");
      $sumaAnterior = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("fob");

      $sumaTotalNac = FacturaNacional::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("neto");
      $sumaTotalNac = ($sumaTotalNac / $valorDolar);
      $sumaAnteriorNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("neto");
      $sumaAnteriorNac = ($sumaAnteriorNac / $valorDolar);

      $yearSelected = Carbon::now()->format('Y');
      $lastYearSelected = Carbon::now()->format('Y') - 1;
      $lastYearSelected = json_encode($lastYearSelected);

      $sumaAcumuladoTotal = FacturaIntl::whereBetween('fecha_emision', [''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("fob");
      $sumaAcumuladoAnterior = FacturaIntl::whereBetween('fecha_emision', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("fob");

      $sumaAcumuladoTotalNac = FacturaNacional::whereBetween('fecha_emision', [''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("neto");
      $sumaAcumuladoTotalNac = ($sumaAcumuladoTotalNac / $valorDolar);
      $sumaAcumuladoAnteriorNac = FacturaNacional::whereBetween('fecha_emision', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("neto");
      $sumaAcumuladoAnteriorNac = ($sumaAcumuladoAnteriorNac / $valorDolar);


      $ventaMesIntl = VentasMercado::consultaVentaMesIntl($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesNovafoods = VentasMercado::consultaVentaMesNovafoods($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesRenova = VentasMercado::consultaVentaMesRenova($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesWalmart = VentasMercado::consultaVentaMesWalmart($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesMercaNacional = VentasMercado::consultaVentaMesMercaNacional($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesSumarca = VentasMercado::consultaVentaMesSumarca($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);

      //Data para gráfico This Year
      $eneroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-01%')->sum("fob");
      $eneroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-01%')->sum("neto");
      $notaCredEneroNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-01%')->sum("neto");
      $eneroNac = ($eneroNac - $notaCredEneroNac) / $valorDolar;
      $sumaTotalEnero = $eneroNac + $eneroIntl;

      $febreroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-02%')->sum("fob");
      $febreroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-02%')->sum("neto");
      $notaCredFebreroNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-02%')->sum("neto");
      $febreroNac = ($febreroNac - $notaCredFebreroNac) / $valorDolar;
      $sumaTotalFebrero = $febreroNac + $febreroIntl;

      $marzoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-03%')->sum("fob");
      $marzoNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-03%')->sum("neto");
      $notaCredMarzoNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-03%')->sum("neto");
      $marzoNac = ($marzoNac - $notaCredMarzoNac) / $valorDolar;
      $sumaTotalMarzo = $marzoNac + $marzoIntl;

      $abrilIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-04%')->sum("fob");
      $abrilNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-04%')->sum("neto");
      $notaCredAbrilNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-04%')->sum("neto");
      $abrilNac = ($abrilNac - $notaCredAbrilNac) / $valorDolar;
      $sumaTotalAbril = $abrilNac + $abrilIntl;

      $mayoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-05%')->sum("fob");
      $mayoNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-05%')->sum("neto");
      $notaCredMayoNac  = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-05%')->sum("neto");
      $mayoNac  = ($mayoNac - $notaCredMayoNac) / $valorDolar;
      $sumaTotalMayo = $mayoNac + $mayoIntl;

      $junioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-06%')->sum("fob");
      $junioNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-06%')->sum("neto");
      $notaCredJunioNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-06%')->sum("neto");
      $junioNac = ($junioNac - $notaCredJunioNac) / $valorDolar;
      $sumaTotalJunio = $junioNac + $junioIntl;

      $julioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-07%')->sum("fob");
      $julioNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-07%')->sum("neto");
      $notaCredJulioNac  = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-07%')->sum("neto");
      $julioNac = ($julioNac - $notaCredJulioNac) / $valorDolar;
      $sumaTotalJulio = $julioNac + $julioIntl;

      $agostoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-08%')->sum("fob");
      $agostoNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-08%')->sum("neto");
      $notaCredAgostoNac =  NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-08%')->sum("neto");
      $agostoNac = ($agostoNac - $notaCredAgostoNac) / $valorDolar;
      $sumaTotalAgosto =  $agostoNac + $agostoIntl;

      $septiembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-09%')->sum("fob");
      $septiembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-09%')->sum("neto");
      $notaCredSeptiembreNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-09%')->sum("neto");
      $septiembreNac = ($septiembreNac - $notaCredSeptiembreNac) / $valorDolar;
      $sumaTotalSeptiembre = $septiembreNac + $septiembreIntl;

      $octubreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-10%')->sum("fob");
      $octubreNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-10%')->sum("neto");
      $notaCredOctubreNac  = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-10%')->sum("neto");
      $octubreNac = ($octubreNac - $notaCredOctubreNac) / $valorDolar;
      $sumaTotalOctubre = $octubreNac + $octubreIntl;

      $noviembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-11%')->sum("fob");
      $noviembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-11%')->sum("neto");
      $notaCredNoviembreNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-11%')->sum("neto");
      $noviembreNac = ($noviembreNac - $notaCredNoviembreNac) / $valorDolar;
      $sumaTotalNoviembre = $noviembreNac + $noviembreIntl;

      $diciembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-12%')->sum("fob");
      $diciembreNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-12%')->sum("neto");
      $notaCredDiciembreNac =  NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-12%')->sum("neto");
      $diciembreNac =  ($diciembreNac - $notaCredDiciembreNac) / $valorDolar;
      $sumaTotalDiciembre = $diciembreNac + $diciembreIntl;

      //Datos para Gráficos Last Year
      $eneroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-01%')->sum("fob");
      $eneroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-01%')->sum("neto");
      $notaCredEneroNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-01%')->sum("neto");
      $eneroNac = ($eneroNac - $notaCredEneroNac) / $valorDolar;
      $totalLastEnero = $eneroNac + $eneroIntl;

      $febreroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-02%')->sum("fob");
      $febreroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-02%')->sum("neto");
      $notaCredFebreroNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-02%')->sum("neto");
      $febreroNac = ($febreroNac - $notaCredFebreroNac) / $valorDolar;
      $totalLastFebrero = $febreroNac + $febreroIntl;

      $marzoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-03%')->sum("fob");
      $marzoNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-03%')->sum("neto");
      $notaCredMarzoNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-03%')->sum("neto");
      $marzoNac = ($marzoNac - $notaCredMarzoNac) / $valorDolar;
      $totalLastMarzo = $marzoNac + $marzoIntl;

      $abrilIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-04%')->sum("fob");
      $abrilNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-04%')->sum("neto");
      $notaCredAbrilNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-04%')->sum("neto");
      $abrilNac = ($abrilNac - $notaCredAbrilNac) / $valorDolar;
      $totalLastAbril = $abrilNac + $abrilIntl;

      $mayoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-05%')->sum("fob");
      $mayoNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-05%')->sum("neto");
      $notaCredMayoNac  = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-05%')->sum("neto");
      $mayoNac  = ($mayoNac - $notaCredMayoNac) / $valorDolar;
      $totalLastMayo = $mayoNac + $mayoIntl;

      $junioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-06%')->sum("fob");
      $junioNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-06%')->sum("neto");
      $notaCredJunioNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-06%')->sum("neto");
      $junioNac = ($junioNac - $notaCredJunioNac) / $valorDolar;
      $totalLastJunio = $junioNac + $junioIntl;

      $julioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-07%')->sum("fob");
      $julioNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-07%')->sum("neto");
      $notaCredJulioNac  = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-07%')->sum("neto");
      $julioNac = ($julioNac - $notaCredJulioNac) / $valorDolar;
      $totalLastJulio = $julioNac + $julioIntl;

      $agostoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-08%')->sum("fob");
      $agostoNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-08%')->sum("neto");
      $notaCredAgostoNac =  NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-08%')->sum("neto");
      $agostoNac = ($agostoNac - $notaCredAgostoNac) / $valorDolar;
      $totalLastAgosto =  $agostoNac + $agostoIntl;

      $septiembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-09%')->sum("fob");
      $septiembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-09%')->sum("neto");
      $notaCredSeptiembreNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-09%')->sum("neto");
      $septiembreNac = ($septiembreNac - $notaCredSeptiembreNac) / $valorDolar;
      $totalLastSeptiembre = $septiembreNac + $septiembreIntl;

      $octubreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-10%')->sum("fob");
      $octubreNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-10%')->sum("neto");
      $notaCredOctubreNac  = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-10%')->sum("neto");
      $octubreNac = ($octubreNac - $notaCredOctubreNac) / $valorDolar;
      $totalLastOctubre = $octubreNac + $octubreIntl;

      $noviembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-11%')->sum("fob");
      $noviembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-11%')->sum("neto");
      $notaCredNoviembreNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-11%')->sum("neto");
      $noviembreNac = ($noviembreNac - $notaCredNoviembreNac) / $valorDolar;
      $totalLastNoviembre = $noviembreNac + $noviembreIntl;

      $diciembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-12%')->sum("fob");
      $diciembreNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-12%')->sum("neto");
      $notaCredDiciembreNac =  NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-12%')->sum("neto");
      $diciembreNac =  ($diciembreNac - $notaCredDiciembreNac) / $valorDolar;
      $totalLastDiciembre = $diciembreNac + $diciembreIntl;

      return view('informes.ventasPorMes.index')->with(['busqueda' => $busqueda, 'ventaMesIntl' => $ventaMesIntl, 'mesActual' => $mesActual, 'mesPasado' => $mesPasado, 'sumaTotal' => $sumaTotal, 'yearSelected' => $yearSelected,  'lastYearSelected' => $lastYearSelected, 'sumaAnterior' => $sumaAnterior, 'sumaTotalEnero' => $sumaTotalEnero, 'sumaTotalFebrero' => $sumaTotalFebrero,
      'sumaTotalMarzo' => $sumaTotalMarzo, 'sumaTotalAbril' => $sumaTotalAbril, 'sumaTotalMayo' => $sumaTotalMayo,
      'sumaTotalJunio' => $sumaTotalJunio, 'sumaTotalJulio' => $sumaTotalJulio, 'sumaTotalAgosto' => $sumaTotalAgosto,
      'sumaTotalSeptiembre' => $sumaTotalSeptiembre, 'sumaTotalOctubre' => $sumaTotalOctubre, 'sumaTotalNoviembre' => $sumaTotalNoviembre, 'sumaTotalDiciembre' => $sumaTotalDiciembre,
      'totalLastEnero' => $totalLastEnero, 'totalLastFebrero' => $totalLastFebrero,
      'totalLastMarzo' => $totalLastMarzo, 'totalLastAbril' => $totalLastAbril, 'totalLastMayo' => $totalLastMayo,
      'totalLastJunio' => $totalLastJunio, 'totalLastJulio' => $totalLastJulio, 'totalLastAgosto' => $totalLastAgosto,
      'totalLastSeptiembre' => $totalLastSeptiembre, 'totalLastOctubre' => $totalLastOctubre, 'totalLastNoviembre' => $totalLastNoviembre, 'totalLastDiciembre' => $totalLastDiciembre, 'sumaAcumuladoTotal' => $sumaAcumuladoTotal, 'sumaAcumuladoAnterior' => $sumaAcumuladoAnterior,
      'ventaMesNovafoods' => $ventaMesNovafoods, 'ventaMesRenova' => $ventaMesRenova, 'ventaMesMercaNacional' => $ventaMesMercaNacional, 'ventaMesSumarca' => $ventaMesSumarca, 'ventaMesWalmart' => $ventaMesWalmart,
      'sumaTotalNac' => $sumaTotalNac, 'sumaAnteriorNac' => $sumaAnteriorNac, 'valorDolar' => $valorDolar, 'sumaAcumuladoTotalNac' => $sumaAcumuladoTotalNac, 'sumaAcumuladoAnteriorNac' => $sumaAcumuladoAnteriorNac]);

    //return view('informes.ventasPorMes.index')->with(['ventaMesIntl' => $ventaMesIntl, 'ventaMesIntlAnterior' => $ventaMesIntlAnterior, 'mesPasado' => $mesPasado, 'mesActual' => $mesActual, 'sumaTotal' => $sumaTotal, 'sumaAnterior' => $sumaAnterior]);
    }


    public function ventasMensuales(Request $request)
    {

      setlocale(LC_ALL, 'es');
      $apiUrl = 'https://mindicador.cl/api';

            if ( ini_get('allow_url_fopen') ) {
              $json = file_get_contents($apiUrl);
            } else {

              $curl = curl_init($apiUrl);
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              $json = curl_exec($curl);
              curl_close($curl);
            }

      $dailyIndicators = json_decode($json);

      $valorDolar = $dailyIndicators->dolar->valor;

      $fechaSelected = $request->dateSelected;
      $lastYear = date('Y-m', strtotime('-1 year', strtotime($fechaSelected)));
      $mesActual = Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');
      $busqueda = $request;

      $sumaTotal = FacturaIntl::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("fob");
      $sumaAnterior = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("fob");

      $sumaTotalNac = FacturaNacional::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("neto");
      $descNotaCreditoNac = NotaCreditoNac::where('fecha', 'like', '%'.$fechaSelected.'%')->sum("neto");
      $sumaTotalNac = (($sumaTotalNac - $descNotaCreditoNac) / $valorDolar);
      $sumaAnteriorNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("neto");
      $lastDescNotaCreditoNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYear.'%')->sum("neto");
      $sumaAnteriorNac = (($sumaAnteriorNac - $lastDescNotaCreditoNac) / $valorDolar);

      $yearSelected = Carbon::now()->format('Y');
      $lastYearSelected = Carbon::now()->format('Y') - 1;
      $lastYearSelected = json_encode($lastYearSelected);

      $sumaAcumuladoTotal = FacturaIntl::whereBetween('fecha_emision', [''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("fob");
      $sumaAcumuladoAnterior = FacturaIntl::whereBetween('fecha_emision', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("fob");

      $sumaAcumuladoTotalNac = FacturaNacional::whereBetween('fecha_emision', [''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("neto");
      $descNotaCreditoNac = NotaCreditoNac::whereBetween('fecha',[''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("neto");
      $sumaAcumuladoTotalNac = (($sumaAcumuladoTotalNac - $descNotaCreditoNac) / $valorDolar);
      $sumaAcumuladoAnteriorNac = FacturaNacional::whereBetween('fecha_emision', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("neto");
      $lastDescNotaCreditoNac = NotaCreditoNac::whereBetween('fecha', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("neto");
      $sumaAcumuladoAnteriorNac = (($sumaAcumuladoAnteriorNac - $lastDescNotaCreditoNac) / $valorDolar);

      $ventaMesIntl = VentasMercado::consultaVentaMesIntl($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesNovafoods = VentasMercado::consultaVentaMesNovafoods($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesRenova = VentasMercado::consultaVentaMesRenova($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesWalmart = VentasMercado::consultaVentaMesWalmart($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesMercaNacional = VentasMercado::consultaVentaMesMercaNacional($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesSumarca = VentasMercado::consultaVentaMesSumarca($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);

      //Data para gráfico This Year
      $eneroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-01%')->sum("fob");
      $eneroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-01%')->sum("neto");
      $notaCredEneroNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-01%')->sum("neto");
      $eneroNac = ($eneroNac - $notaCredEneroNac) / $valorDolar;
      $sumaTotalEnero = $eneroNac + $eneroIntl;

      $febreroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-02%')->sum("fob");
      $febreroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-02%')->sum("neto");
      $notaCredFebreroNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-02%')->sum("neto");
      $febreroNac = ($febreroNac - $notaCredFebreroNac) / $valorDolar;
      $sumaTotalFebrero = $febreroNac + $febreroIntl;

      $marzoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-03%')->sum("fob");
      $marzoNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-03%')->sum("neto");
      $notaCredMarzoNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-03%')->sum("neto");
      $marzoNac = ($marzoNac - $notaCredMarzoNac) / $valorDolar;
      $sumaTotalMarzo = $marzoNac + $marzoIntl;

      $abrilIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-04%')->sum("fob");
      $abrilNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-04%')->sum("neto");
      $notaCredAbrilNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-04%')->sum("neto");
      $abrilNac = ($abrilNac - $notaCredAbrilNac) / $valorDolar;
      $sumaTotalAbril = $abrilNac + $abrilIntl;

      $mayoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-05%')->sum("fob");
      $mayoNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-05%')->sum("neto");
      $notaCredMayoNac  = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-05%')->sum("neto");
      $mayoNac  = ($mayoNac - $notaCredMayoNac) / $valorDolar;
      $sumaTotalMayo = $mayoNac + $mayoIntl;

      $junioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-06%')->sum("fob");
      $junioNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-06%')->sum("neto");
      $notaCredJunioNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-06%')->sum("neto");
      $junioNac = ($junioNac - $notaCredJunioNac) / $valorDolar;
      $sumaTotalJunio = $junioNac + $junioIntl;

      $julioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-07%')->sum("fob");
      $julioNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-07%')->sum("neto");
      $notaCredJulioNac  = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-07%')->sum("neto");
      $julioNac = ($julioNac - $notaCredJulioNac) / $valorDolar;
      $sumaTotalJulio = $julioNac + $julioIntl;

      $agostoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-08%')->sum("fob");
      $agostoNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-08%')->sum("neto");
      $notaCredAgostoNac =  NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-08%')->sum("neto");
      $agostoNac = ($agostoNac - $notaCredAgostoNac) / $valorDolar;
      $sumaTotalAgosto =  $agostoNac + $agostoIntl;

      $septiembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-09%')->sum("fob");
      $septiembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-09%')->sum("neto");
      $notaCredSeptiembreNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-09%')->sum("neto");
      $septiembreNac = ($septiembreNac - $notaCredSeptiembreNac) / $valorDolar;
      $sumaTotalSeptiembre = $septiembreNac + $septiembreIntl;

      $octubreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-10%')->sum("fob");
      $octubreNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-10%')->sum("neto");
      $notaCredOctubreNac  = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-10%')->sum("neto");
      $octubreNac = ($octubreNac - $notaCredOctubreNac) / $valorDolar;
      $sumaTotalOctubre = $octubreNac + $octubreIntl;

      $noviembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-11%')->sum("fob");
      $noviembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-11%')->sum("neto");
      $notaCredNoviembreNac = NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-11%')->sum("neto");
      $noviembreNac = ($noviembreNac - $notaCredNoviembreNac) / $valorDolar;
      $sumaTotalNoviembre = $noviembreNac + $noviembreIntl;

      $diciembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-12%')->sum("fob");
      $diciembreNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-12%')->sum("neto");
      $notaCredDiciembreNac =  NotaCreditoNac::where('fecha', 'like', '%'.$yearSelected.'-12%')->sum("neto");
      $diciembreNac =  ($diciembreNac - $notaCredDiciembreNac) / $valorDolar;
      $sumaTotalDiciembre = $diciembreNac + $diciembreIntl;

      //Datos para Gráficos Last Year
      $eneroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-01%')->sum("fob");
      $eneroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-01%')->sum("neto");
      $notaCredEneroNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-01%')->sum("neto");
      $eneroNac = ($eneroNac - $notaCredEneroNac) / $valorDolar;
      $totalLastEnero = $eneroNac + $eneroIntl;

      $febreroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-02%')->sum("fob");
      $febreroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-02%')->sum("neto");
      $notaCredFebreroNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-02%')->sum("neto");
      $febreroNac = ($febreroNac - $notaCredFebreroNac) / $valorDolar;
      $totalLastFebrero = $febreroNac + $febreroIntl;

      $marzoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-03%')->sum("fob");
      $marzoNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-03%')->sum("neto");
      $notaCredMarzoNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-03%')->sum("neto");
      $marzoNac = ($marzoNac - $notaCredMarzoNac) / $valorDolar;
      $totalLastMarzo = $marzoNac + $marzoIntl;

      $abrilIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-04%')->sum("fob");
      $abrilNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-04%')->sum("neto");
      $notaCredAbrilNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-04%')->sum("neto");
      $abrilNac = ($abrilNac - $notaCredAbrilNac) / $valorDolar;
      $totalLastAbril = $abrilNac + $abrilIntl;

      $mayoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-05%')->sum("fob");
      $mayoNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-05%')->sum("neto");
      $notaCredMayoNac  = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-05%')->sum("neto");
      $mayoNac  = ($mayoNac - $notaCredMayoNac) / $valorDolar;
      $totalLastMayo = $mayoNac + $mayoIntl;

      $junioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-06%')->sum("fob");
      $junioNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-06%')->sum("neto");
      $notaCredJunioNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-06%')->sum("neto");
      $junioNac = ($junioNac - $notaCredJunioNac) / $valorDolar;
      $totalLastJunio = $junioNac + $junioIntl;

      $julioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-07%')->sum("fob");
      $julioNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-07%')->sum("neto");
      $notaCredJulioNac  = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-07%')->sum("neto");
      $julioNac = ($julioNac - $notaCredJulioNac) / $valorDolar;
      $totalLastJulio = $julioNac + $julioIntl;

      $agostoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-08%')->sum("fob");
      $agostoNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-08%')->sum("neto");
      $notaCredAgostoNac =  NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-08%')->sum("neto");
      $agostoNac = ($agostoNac - $notaCredAgostoNac) / $valorDolar;
      $totalLastAgosto =  $agostoNac + $agostoIntl;

      $septiembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-09%')->sum("fob");
      $septiembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-09%')->sum("neto");
      $notaCredSeptiembreNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-09%')->sum("neto");
      $septiembreNac = ($septiembreNac - $notaCredSeptiembreNac) / $valorDolar;
      $totalLastSeptiembre = $septiembreNac + $septiembreIntl;

      $octubreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-10%')->sum("fob");
      $octubreNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-10%')->sum("neto");
      $notaCredOctubreNac  = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-10%')->sum("neto");
      $octubreNac = ($octubreNac - $notaCredOctubreNac) / $valorDolar;
      $totalLastOctubre = $octubreNac + $octubreIntl;

      $noviembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-11%')->sum("fob");
      $noviembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-11%')->sum("neto");
      $notaCredNoviembreNac = NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-11%')->sum("neto");
      $noviembreNac = ($noviembreNac - $notaCredNoviembreNac) / $valorDolar;
      $totalLastNoviembre = $noviembreNac + $noviembreIntl;

      $diciembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-12%')->sum("fob");
      $diciembreNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-12%')->sum("neto");
      $notaCredDiciembreNac =  NotaCreditoNac::where('fecha', 'like', '%'.$lastYearSelected.'-12%')->sum("neto");
      $diciembreNac =  ($diciembreNac - $notaCredDiciembreNac) / $valorDolar;
      $totalLastDiciembre = $diciembreNac + $diciembreIntl;

      return view('informes.ventasPorMes.index')->with(['busqueda' => $busqueda, 'ventaMesIntl' => $ventaMesIntl, 'mesActual' => $mesActual, 'mesPasado' => $mesPasado, 'sumaTotal' => $sumaTotal, 'yearSelected' => $yearSelected,  'lastYearSelected' => $lastYearSelected, 'sumaAnterior' => $sumaAnterior, 'sumaTotalEnero' => $sumaTotalEnero, 'sumaTotalFebrero' => $sumaTotalFebrero,
      'sumaTotalMarzo' => $sumaTotalMarzo, 'sumaTotalAbril' => $sumaTotalAbril, 'sumaTotalMayo' => $sumaTotalMayo,
      'sumaTotalJunio' => $sumaTotalJunio, 'sumaTotalJulio' => $sumaTotalJulio, 'sumaTotalAgosto' => $sumaTotalAgosto,
      'sumaTotalSeptiembre' => $sumaTotalSeptiembre, 'sumaTotalOctubre' => $sumaTotalOctubre, 'sumaTotalNoviembre' => $sumaTotalNoviembre, 'sumaTotalDiciembre' => $sumaTotalDiciembre,
      'totalLastEnero' => $totalLastEnero, 'totalLastFebrero' => $totalLastFebrero,
      'totalLastMarzo' => $totalLastMarzo, 'totalLastAbril' => $totalLastAbril, 'totalLastMayo' => $totalLastMayo,
      'totalLastJunio' => $totalLastJunio, 'totalLastJulio' => $totalLastJulio, 'totalLastAgosto' => $totalLastAgosto,
      'totalLastSeptiembre' => $totalLastSeptiembre, 'totalLastOctubre' => $totalLastOctubre, 'totalLastNoviembre' => $totalLastNoviembre, 'totalLastDiciembre' => $totalLastDiciembre, 'sumaAcumuladoTotal' => $sumaAcumuladoTotal, 'sumaAcumuladoAnterior' => $sumaAcumuladoAnterior,
      'ventaMesNovafoods' => $ventaMesNovafoods, 'ventaMesRenova' => $ventaMesRenova, 'ventaMesMercaNacional' => $ventaMesMercaNacional, 'ventaMesSumarca' => $ventaMesSumarca, 'ventaMesWalmart' => $ventaMesWalmart,
      'sumaTotalNac' => $sumaTotalNac, 'sumaAnteriorNac' => $sumaAnteriorNac, 'valorDolar' => $valorDolar, 'sumaAcumuladoTotalNac' => $sumaAcumuladoTotalNac, 'sumaAcumuladoAnteriorNac' => $sumaAcumuladoAnteriorNac]);

    }

    public function ventasMensualesNacional(Request $request)
    {

      setlocale(LC_ALL, 'es');

      $apiUrl = 'https://mindicador.cl/api';

            if ( ini_get('allow_url_fopen') ) {
              $json = file_get_contents($apiUrl);
            } else {

              $curl = curl_init($apiUrl);
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              $json = curl_exec($curl);
              curl_close($curl);
            }

      $dailyIndicators = json_decode($json);

      $valorDolar = $dailyIndicators->dolar->valor;

      $fechaSelected = $request->dateSelected;
      $lastYear = date('Y-m', strtotime('-1 year', strtotime($fechaSelected)));
      $mesActual = Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');

      $sumaTotalNac = FacturaNacional::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("neto");
      $sumaTotalNac = ($sumaTotalNac / $valorDolar);
      $sumaAnteriorNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("neto");
      $sumaAnteriorNac = ($sumaAnteriorNac / $valorDolar);

      $yearSelected = Carbon::now()->format('Y');
      $lastYearSelected = Carbon::now()->format('Y') - 1;
      $lastYearSelected = json_encode($lastYearSelected);

      $sumaAcumuladoTotalNac = FacturaNacional::whereBetween('fecha_emision', [''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("neto");
      $sumaAcumuladoTotalNac = ($sumaAcumuladoTotalNac / $valorDolar);
      $sumaAcumuladoAnteriorNac = FacturaNacional::whereBetween('fecha_emision', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("neto");
      $sumaAcumuladoAnteriorNac = ($sumaAcumuladoAnteriorNac / $valorDolar);

      $ventaMesNovafoods = VentasMercado::consultaVentaMesNovafoods($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesRenova = VentasMercado::consultaVentaMesRenova($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesWalmart = VentasMercado::consultaVentaMesWalmart($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesMercaNacional = VentasMercado::consultaVentaMesMercaNacional($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesSumarca = VentasMercado::consultaVentaMesSumarca($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);

      //Data para gráfico
      $eneroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-01%')->sum("neto");
      $sumaTotalEnero = $eneroNac / $valorDolar;
      $febreroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-02%')->sum("neto");
      $sumaTotalFebrero = $febreroNac / $valorDolar;
      $marzoNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-03%')->sum("neto");
      $sumaTotalMarzo = $marzoNac / $valorDolar;
      $abrilNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-04%')->sum("neto");
      $sumaTotalAbril = $abrilNac / $valorDolar;
      $mayoNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-05%')->sum("neto");
      $sumaTotalMayo  = $mayoNac / $valorDolar;
      $junioNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-06%')->sum("neto");
      $sumaTotalJunio = $junioNac / $valorDolar;
      $julioNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-07%')->sum("neto");
      $sumaTotalJulio = $julioNac / $valorDolar;
      $agostoNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-08%')->sum("neto");
      $sumaTotalAgosto = $agostoNac / $valorDolar;
      $septiembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-09%')->sum("neto");
      $sumaTotalSeptiembre = $septiembreNac / $valorDolar;
      $octubreNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-10%')->sum("neto");
      $sumaTotalOctubre = $octubreNac / $valorDolar;
      $noviembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-11%')->sum("neto");
      $sumaTotalNoviembre = $noviembreNac / $valorDolar;
      $diciembreNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-12%')->sum("neto");
      $sumaTotalDiciembre =  $diciembreNac / $valorDolar;

      $eneroNacAnt = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-01%')->sum("neto");
      $totalLastEnero = $eneroNacAnt / $valorDolar;
      $febreroNacAnt = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-02%')->sum("neto");
      $totalLastFebrero = $febreroNacAnt / $valorDolar;
      $marzoNacAnt = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-03%')->sum("neto");
      $totalLastMarzo = $marzoNacAnt / $valorDolar;
      $abrilNacAnt = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-04%')->sum("neto");
      $totalLastAbril = $abrilNacAnt / $valorDolar;
      $mayoNacAnt  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-05%')->sum("neto");
      $totalLastMayo  = $mayoNacAnt / $valorDolar;
      $junioNacAnt = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-06%')->sum("neto");
      $totalLastJunio = $junioNacAnt / $valorDolar;
      $julioNacAnt  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-07%')->sum("neto");
      $totalLastJulio = $julioNacAnt / $valorDolar;
      $agostoNacAnt =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-08%')->sum("neto");
      $totalLastAgosto = $agostoNacAnt / $valorDolar;
      $septiembreNacAnt = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-09%')->sum("neto");
      $totalLastSeptiembre = $septiembreNacAnt / $valorDolar;
      $octubreNacAnt  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-10%')->sum("neto");
      $totalLastOctubre = $octubreNacAnt / $valorDolar;
      $noviembreNacAnt = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-11%')->sum("neto");
      $totalLastNoviembre = $noviembreNacAnt / $valorDolar;
      $diciembreNacAnt =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-12%')->sum("neto");
      $totalLastDiciembre =  $diciembreNacAnt / $valorDolar;

      return view('informes.ventasPorMes.ventasNac')->with(['mesActual' => $mesActual, 'mesPasado' => $mesPasado, 'yearSelected' => $yearSelected,  'lastYearSelected' => $lastYearSelected,
      'sumaTotalEnero' => $sumaTotalEnero, 'sumaTotalFebrero' => $sumaTotalFebrero, 'sumaTotalMarzo' => $sumaTotalMarzo, 'sumaTotalAbril' => $sumaTotalAbril, 'sumaTotalMayo' => $sumaTotalMayo,
      'sumaTotalJunio' => $sumaTotalJunio, 'sumaTotalJulio' => $sumaTotalJulio, 'sumaTotalAgosto' => $sumaTotalAgosto, 'sumaTotalSeptiembre' => $sumaTotalSeptiembre,
      'sumaTotalOctubre' => $sumaTotalOctubre, 'sumaTotalNoviembre' => $sumaTotalNoviembre, 'sumaTotalDiciembre' => $sumaTotalDiciembre,

      'totalLastEnero' => $totalLastEnero, 'totalLastFebrero' => $totalLastFebrero, 'totalLastMarzo' => $totalLastMarzo, 'totalLastAbril' => $totalLastAbril, 'totalLastMayo' => $totalLastMayo,
      'totalLastJunio' => $totalLastJunio, 'totalLastJulio' => $totalLastJulio, 'totalLastAgosto' => $totalLastAgosto, 'totalLastSeptiembre' => $totalLastSeptiembre,
      'totalLastOctubre' => $totalLastOctubre, 'totalLastNoviembre' => $totalLastNoviembre, 'totalLastDiciembre' => $totalLastDiciembre,

      'ventaMesNovafoods' => $ventaMesNovafoods, 'ventaMesRenova' => $ventaMesRenova, 'ventaMesMercaNacional' => $ventaMesMercaNacional, 'ventaMesSumarca' => $ventaMesSumarca, 'ventaMesWalmart' => $ventaMesWalmart,
      'sumaTotalNac' => $sumaTotalNac, 'sumaAnteriorNac' => $sumaAnteriorNac, 'valorDolar' => $valorDolar, 'sumaAcumuladoTotalNac' => $sumaAcumuladoTotalNac, 'sumaAcumuladoAnteriorNac' => $sumaAcumuladoAnteriorNac]);

    }

    public function ventasMensualesInternacional(Request $request)
    {

      setlocale(LC_ALL, 'es');

      $fechaSelected = $request->dateSelected;
      $lastYear = date('Y-m', strtotime('-1 year', strtotime($fechaSelected)));
      $mesActual = Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');

      $sumaTotal = FacturaIntl::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("fob");
      $sumaAnterior = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("fob");

      $yearSelected = Carbon::now()->format('Y');
      $lastYearSelected = Carbon::now()->format('Y') - 1;
      $lastYearSelected = json_encode($lastYearSelected);

      $sumaAcumuladoTotal = FacturaIntl::whereBetween('fecha_emision', [''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("fob");
      $sumaAcumuladoAnterior = FacturaIntl::whereBetween('fecha_emision', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("fob");

      $ventaMesIntl = VentasMercado::consultaVentaMesIntl($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);

      //Data para gráfico
      $sumaTotalEnero = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-01%')->sum("fob");
      $sumaTotalFebrero = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-02%')->sum("fob");
      $sumaTotalMarzo = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-03%')->sum("fob");
      $sumaTotalAbril = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-04%')->sum("fob");
      $sumaTotalMayo = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-05%')->sum("fob");
      $sumaTotalJunio = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-06%')->sum("fob");
      $sumaTotalJulio = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-07%')->sum("fob");
      $sumaTotalAgosto = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-08%')->sum("fob");
      $sumaTotalSeptiembre = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-09%')->sum("fob");
      $sumaTotalOctubre = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-10%')->sum("fob");
      $sumaTotalNoviembre = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-11%')->sum("fob");
      $sumaTotalDiciembre = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-12%')->sum("fob");



      $totalLastEnero = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-01%')->sum("fob");
      $totalLastFebrero = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-02%')->sum("fob");
      $totalLastMarzo = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-03%')->sum("fob");
      $totalLastAbril = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-04%')->sum("fob");
      $totalLastMayo = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-05%')->sum("fob");
      $totalLastJunio = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-06%')->sum("fob");
      $totalLastJulio = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-07%')->sum("fob");
      $totalLastAgosto = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-08%')->sum("fob");
      $totalLastSeptiembre = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-09%')->sum("fob");
      $totalLastOctubre = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-10%')->sum("fob");
      $totalLastNoviembre = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-11%')->sum("fob");
      $totalLastDiciembre = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-12%')->sum("fob");


      return view('informes.ventasPorMes.ventasIntl')->with(['ventaMesIntl' => $ventaMesIntl, 'mesActual' => $mesActual, 'mesPasado' => $mesPasado, 'sumaTotal' => $sumaTotal, 'yearSelected' => $yearSelected,  'lastYearSelected' => $lastYearSelected, 'sumaAnterior' => $sumaAnterior, 'sumaTotalEnero' => $sumaTotalEnero, 'sumaTotalFebrero' => $sumaTotalFebrero,
      'sumaTotalMarzo' => $sumaTotalMarzo, 'sumaTotalAbril' => $sumaTotalAbril, 'sumaTotalMayo' => $sumaTotalMayo,
      'sumaTotalJunio' => $sumaTotalJunio, 'sumaTotalJulio' => $sumaTotalJulio, 'sumaTotalAgosto' => $sumaTotalAgosto,
      'sumaTotalSeptiembre' => $sumaTotalSeptiembre, 'sumaTotalOctubre' => $sumaTotalOctubre, 'sumaTotalNoviembre' => $sumaTotalNoviembre, 'sumaTotalDiciembre' => $sumaTotalDiciembre,
      'totalLastEnero' => $totalLastEnero, 'totalLastFebrero' => $totalLastFebrero,
      'totalLastMarzo' => $totalLastMarzo, 'totalLastAbril' => $totalLastAbril, 'totalLastMayo' => $totalLastMayo,
      'totalLastJunio' => $totalLastJunio, 'totalLastJulio' => $totalLastJulio, 'totalLastAgosto' => $totalLastAgosto,
      'totalLastSeptiembre' => $totalLastSeptiembre, 'totalLastOctubre' => $totalLastOctubre, 'totalLastNoviembre' => $totalLastNoviembre, 'totalLastDiciembre' => $totalLastDiciembre, 'sumaAcumuladoTotal' => $sumaAcumuladoTotal, 'sumaAcumuladoAnterior' => $sumaAcumuladoAnterior]);

    }


    public function ventasReportTotalExcel(Request $request)
    {

      setlocale(LC_ALL, 'es');
      $apiUrl = 'https://mindicador.cl/api';

            if ( ini_get('allow_url_fopen') ) {
              $json = file_get_contents($apiUrl);
            } else {

              $curl = curl_init($apiUrl);
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              $json = curl_exec($curl);
              curl_close($curl);
            }

      $dailyIndicators = json_decode($json);

      $valorDolar = $dailyIndicators->dolar->valor;

      $fechaSelected = $request->dateSelected;
      $lastYear = date('Y-m', strtotime('-1 year', strtotime($fechaSelected)));
      $mesActual = Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');

      $sumaTotal = FacturaIntl::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("fob");
      $sumaAnterior = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("fob");

      $sumaTotalNac = FacturaNacional::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("neto");
      $sumaTotalNac = ($sumaTotalNac / $valorDolar);
      $sumaAnteriorNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("neto");
      $sumaAnteriorNac = ($sumaAnteriorNac / $valorDolar);

      $yearSelected = Carbon::now()->format('Y');
      $lastYearSelected = Carbon::now()->format('Y') - 1;
      $lastYearSelected = json_encode($lastYearSelected);

      $sumaAcumuladoTotal = FacturaIntl::whereBetween('fecha_emision', [''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("fob");
      $sumaAcumuladoAnterior = FacturaIntl::whereBetween('fecha_emision', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("fob");

      $sumaAcumuladoTotalNac = FacturaNacional::whereBetween('fecha_emision', [''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("neto");
      $sumaAcumuladoTotalNac = ($sumaAcumuladoTotalNac / $valorDolar);
      $sumaAcumuladoAnteriorNac = FacturaNacional::whereBetween('fecha_emision', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("neto");
      $sumaAcumuladoAnteriorNac = ($sumaAcumuladoAnteriorNac / $valorDolar);

      $ventaMesIntl = VentasMercado::consultaVentaMesIntl($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesNovafoods = VentasMercado::consultaVentaMesNovafoods($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesRenova = VentasMercado::consultaVentaMesRenova($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesWalmart = VentasMercado::consultaVentaMesWalmart($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesMercaNacional = VentasMercado::consultaVentaMesMercaNacional($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);
      $ventaMesSumarca = VentasMercado::consultaVentaMesSumarca($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);

      //Data para gráfico
      $eneroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-01%')->sum("fob");
      $eneroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-01%')->sum("neto");
      $eneroNac = $eneroNac / $valorDolar;
      $sumaTotalEnero = $eneroNac + $eneroIntl;
      $febreroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-02%')->sum("fob");
      $febreroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-02%')->sum("neto");
      $febreroNac = $febreroNac / $valorDolar;
      $sumaTotalFebrero = $febreroNac + $febreroIntl;
      $marzoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-03%')->sum("fob");
      $marzoNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-03%')->sum("neto");
      $marzoNac = $marzoNac / $valorDolar;
      $sumaTotalMarzo = $marzoNac + $marzoIntl;
      $abrilIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-04%')->sum("fob");
      $abrilNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-04%')->sum("neto");
      $abrilNac = $abrilNac / $valorDolar;
      $sumaTotalAbril = $abrilNac + $abrilIntl;
      $mayoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-05%')->sum("fob");
      $mayoNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-05%')->sum("neto");
      $mayoNac  = $mayoNac / $valorDolar;
      $sumaTotalMayo = $mayoNac + $mayoIntl;
      $junioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-06%')->sum("fob");
      $junioNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-06%')->sum("neto");
      $junioNac = $junioNac / $valorDolar;
      $sumaTotalJunio = $junioNac + $junioIntl;
      $julioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-07%')->sum("fob");
      $julioNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-07%')->sum("neto");
      $julioNac = $julioNac / $valorDolar;
      $sumaTotalJulio = $julioNac + $julioIntl;
      $agostoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-08%')->sum("fob");
      $agostoNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-08%')->sum("neto");
      $agostoNac = $agostoNac / $valorDolar;
      $sumaTotalAgosto =  $agostoNac + $agostoIntl;
      $septiembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-09%')->sum("fob");
      $septiembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-09%')->sum("neto");
      $septiembreNac = $septiembreNac / $valorDolar;
      $sumaTotalSeptiembre = $septiembreNac + $septiembreIntl;
      $octubreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-10%')->sum("fob");
      $octubreNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-10%')->sum("neto");
      $octubreNac = $octubreNac / $valorDolar;
      $sumaTotalOctubre = $octubreNac + $octubreIntl;
      $noviembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-11%')->sum("fob");
      $noviembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-11%')->sum("neto");
      $noviembreNac = $noviembreNac / $valorDolar;
      $sumaTotalNoviembre = $noviembreNac + $noviembreIntl;
      $diciembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-12%')->sum("fob");
      $diciembreNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$yearSelected.'-12%')->sum("neto");
      $diciembreNac =  $diciembreNac / $valorDolar;
      $sumaTotalDiciembre = $diciembreNac + $diciembreIntl;


      $eneroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-01%')->sum("fob");
      $eneroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-01%')->sum("neto");
      $eneroNac = $eneroNac / $valorDolar;
      $totalLastEnero = $eneroNac + $eneroIntl;
      $febreroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-02%')->sum("fob");
      $febreroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-02%')->sum("neto");
      $febreroNac = $febreroNac / $valorDolar;
      $totalLastFebrero = $febreroNac + $febreroIntl;
      $marzoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-03%')->sum("fob");
      $marzoNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-03%')->sum("neto");
      $marzoNac = $marzoNac / $valorDolar;
      $totalLastMarzo = $marzoNac + $marzoIntl;
      $abrilIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-04%')->sum("fob");
      $abrilNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-04%')->sum("neto");
      $abrilNac = $abrilNac / $valorDolar;
      $totalLastAbril = $abrilNac + $abrilIntl;
      $mayoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-05%')->sum("fob");
      $mayoNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-05%')->sum("neto");
      $mayoNac  = $mayoNac / $valorDolar;
      $totalLastMayo = $mayoNac + $mayoIntl;
      $junioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-06%')->sum("fob");
      $junioNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-06%')->sum("neto");
      $junioNac = $junioNac / $valorDolar;
      $totalLastJunio = $junioNac + $junioIntl;
      $julioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-07%')->sum("fob");
      $julioNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-07%')->sum("neto");
      $julioNac = $julioNac / $valorDolar;
      $totalLastJulio = $julioNac + $julioIntl;
      $agostoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-08%')->sum("fob");
      $agostoNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-08%')->sum("neto");
      $agostoNac = $agostoNac / $valorDolar;
      $totalLastAgosto =  $agostoNac + $agostoIntl;
      $septiembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-09%')->sum("fob");
      $septiembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-09%')->sum("neto");
      $septiembreNac = $septiembreNac / $valorDolar;
      $totalLastSeptiembre = $septiembreNac + $septiembreIntl;
      $octubreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-10%')->sum("fob");
      $octubreNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-10%')->sum("neto");
      $octubreNac = $octubreNac / $valorDolar;
      $totalLastOctubre = $octubreNac + $octubreIntl;
      $noviembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-11%')->sum("fob");
      $noviembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-11%')->sum("neto");
      $noviembreNac = $noviembreNac / $valorDolar;
      $totalLastNoviembre = $noviembreNac + $noviembreIntl;
      $diciembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-12%')->sum("fob");
      $diciembreNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYearSelected.'-12%')->sum("neto");
      $diciembreNac =  $diciembreNac / $valorDolar;
      $totalLastDiciembre = $diciembreNac + $diciembreIntl;

      return Excel::create('Reporte Ventas Total', function($excel) use ($ventaMesIntl, $mesActual, $mesPasado, $sumaTotal, $yearSelected, $lastYearSelected, $sumaAnterior, $sumaTotalEnero, $sumaTotalFebrero,$sumaTotalMarzo, $sumaTotalAbril,
              $sumaTotalMayo,$sumaTotalJunio, $sumaTotalJulio, $sumaTotalAgosto,$sumaTotalSeptiembre, $sumaTotalOctubre, $sumaTotalNoviembre, $sumaTotalDiciembre, $totalLastEnero,
              $totalLastFebrero, $totalLastMarzo, $totalLastAbril, $totalLastMayo, $totalLastJunio, $totalLastJulio, $totalLastAgosto,$totalLastSeptiembre, $totalLastOctubre,
              $totalLastNoviembre, $totalLastDiciembre, $sumaAcumuladoTotal, $sumaAcumuladoAnterior,$ventaMesNovafoods, $ventaMesRenova, $ventaMesMercaNacional, $ventaMesSumarca,
              $sumaTotalNac, $sumaAnteriorNac, $valorDolar, $sumaAcumuladoTotalNac, $sumaAcumuladoAnteriorNac, $ventaMesWalmart) {
                  $excel->sheet('Resumen', function($sheet) use ($ventaMesIntl, $mesActual, $mesPasado, $sumaTotal, $yearSelected, $lastYearSelected, $sumaAnterior, $sumaTotalEnero, $sumaTotalFebrero,$sumaTotalMarzo, $sumaTotalAbril,
                  $sumaTotalMayo,$sumaTotalJunio, $sumaTotalJulio, $sumaTotalAgosto,$sumaTotalSeptiembre, $sumaTotalOctubre, $sumaTotalNoviembre, $sumaTotalDiciembre, $totalLastEnero,
                  $totalLastFebrero, $totalLastMarzo, $totalLastAbril, $totalLastMayo, $totalLastJunio, $totalLastJulio, $totalLastAgosto,$totalLastSeptiembre, $totalLastOctubre,
                  $totalLastNoviembre, $totalLastDiciembre, $sumaAcumuladoTotal, $sumaAcumuladoAnterior,$ventaMesNovafoods, $ventaMesRenova, $ventaMesMercaNacional, $ventaMesSumarca,
                  $sumaTotalNac, $sumaAnteriorNac, $valorDolar, $sumaAcumuladoTotalNac, $sumaAcumuladoAnteriorNac, $ventaMesWalmart) {
                      $sheet->loadView('documents.excel.ventasReportTotalExcel')
                              ->with(['ventaMesIntl' => $ventaMesIntl, 'mesActual' => $mesActual, 'mesPasado' => $mesPasado, 'sumaTotal' => $sumaTotal, 'yearSelected' => $yearSelected,  'lastYearSelected' => $lastYearSelected, 'sumaAnterior' => $sumaAnterior, 'sumaTotalEnero' => $sumaTotalEnero, 'sumaTotalFebrero' => $sumaTotalFebrero,
                              'sumaTotalMarzo' => $sumaTotalMarzo, 'sumaTotalAbril' => $sumaTotalAbril, 'sumaTotalMayo' => $sumaTotalMayo,
                              'sumaTotalJunio' => $sumaTotalJunio, 'sumaTotalJulio' => $sumaTotalJulio, 'sumaTotalAgosto' => $sumaTotalAgosto,
                              'sumaTotalSeptiembre' => $sumaTotalSeptiembre, 'sumaTotalOctubre' => $sumaTotalOctubre, 'sumaTotalNoviembre' => $sumaTotalNoviembre, 'sumaTotalDiciembre' => $sumaTotalDiciembre,
                              'totalLastEnero' => $totalLastEnero, 'totalLastFebrero' => $totalLastFebrero,
                              'totalLastMarzo' => $totalLastMarzo, 'totalLastAbril' => $totalLastAbril, 'totalLastMayo' => $totalLastMayo,
                              'totalLastJunio' => $totalLastJunio, 'totalLastJulio' => $totalLastJulio, 'totalLastAgosto' => $totalLastAgosto,
                              'totalLastSeptiembre' => $totalLastSeptiembre, 'totalLastOctubre' => $totalLastOctubre, 'totalLastNoviembre' => $totalLastNoviembre, 'totalLastDiciembre' => $totalLastDiciembre, 'sumaAcumuladoTotal' => $sumaAcumuladoTotal, 'sumaAcumuladoAnterior' => $sumaAcumuladoAnterior,
                              'ventaMesNovafoods' => $ventaMesNovafoods, 'ventaMesRenova' => $ventaMesRenova, 'ventaMesMercaNacional' => $ventaMesMercaNacional, 'ventaMesSumarca' => $ventaMesSumarca, 'ventaMesWalmart' => $ventaMesWalmart,
                              'sumaTotalNac' => $sumaTotalNac, 'sumaAnteriorNac' => $sumaAnteriorNac, 'valorDolar' => $valorDolar, 'sumaAcumuladoTotalNac' => $sumaAcumuladoTotalNac, 'sumaAcumuladoAnteriorNac' => $sumaAcumuladoAnteriorNac]);
                          })->download('xlsx');
                      })->download('xlsx');

    }

    public function cierreMesIntl(Request $request) {

      $actualYearFilter = isset($request->actualYear) ? true : false;
      $lastYearFilter = isset($request->lastYear) ? true : false;
      $previousYearFilter = isset($request->previousYear) ? true : false;

      $data = CierreMes::cierreMesIntl($request);
      $now = Carbon::now();
      $currentYear = $now->year;
      $lastYear = $now->year-1;
      $previousYear = $now->year-2;
      $years = [$currentYear,$lastYear,$previousYear];
      $yearOptions = [$actualYearFilter,$lastYearFilter,$previousYearFilter];

      $fechaSelected = $request->dateSelected;

      if ($fechaSelected == null){
        $ventasMesIntl = [];
        $totalVentasMesIntl = '';
      } else {
        $ventasMesIntl = VentasMercado::consultaFacturasIntl($fechaSelected);
        $totalVentasMesIntl = VentasMercado::consultaTotalFacturasIntl($fechaSelected);
      }

      return view('informes.cierreMes.cierreMesIntl')->with(['data'=>$data,'years' => $years,'yearOptions'=>$yearOptions,
                                                              'ventasMesIntl' => $ventasMesIntl, 'totalVentasMesIntl' => $totalVentasMesIntl]);
    }

    public function cierreMesTotal(Request $request) {

      $actualYearFilter = isset($request->actualYear) ? true : false;
      $lastYearFilter = isset($request->lastYear) ? true : false;
      $previousYearFilter = isset($request->previousYear) ? true : false;

      $data = CierreMes::cierreMesIntl($request);
      $now = Carbon::now();
      $currentYear = $now->year;
      $lastYear = $now->year-1;
      $previousYear = $now->year-2;
      $years = [$currentYear,$lastYear,$previousYear];
      $yearOptions = [$actualYearFilter,$lastYearFilter,$previousYearFilter];

      $valorDolar = 752.30;

      $fechaSelected = $request->dateSelected;

      if ($fechaSelected == null){
        $ventasMesIntl = [];
        $totalVentasMesIntl = '';
        $cierreMesNovafoods = '';
        $cierreMesRenova = '';
        $cierreMesWalmart = '';
        $cierreMesMercaNacional = '';
        $cierreMesSumarca = [];
        $totalVentasMesNac = '';

      } else {
        $ventasMesIntl = VentasMercado::consultaFacturasIntl($fechaSelected);
        $totalVentasMesIntl = VentasMercado::consultaTotalFacturasIntl($fechaSelected);

        $cierreMesNovafoods = VentasMercado::cierreMesNovafoods($fechaSelected);
        $cierreMesRenova = VentasMercado::cierreMesRenova($fechaSelected);
        $cierreMesWalmart = VentasMercado::cierreMesWalmart($fechaSelected);
        $cierreMesMercaNacional = VentasMercado::cierreMesMercaNacional($fechaSelected);
        $cierreMesSumarca = VentasMercado::cierreMesSumarca($fechaSelected);
        $totalVentasMesNac = VentasMercado::consultaTotalFacturasNac($fechaSelected);

        }
        //Datos para Resumen
        $eneroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-01%')->sum("fob");
        $eneroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-01%')->sum("neto");
        $eneroNac = $eneroNac / $valorDolar;
        $sumaTotalEnero = $eneroNac + $eneroIntl;
        $febreroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-02%')->sum("fob");
        $febreroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-02%')->sum("neto");
        $febreroNac = $febreroNac / $valorDolar;
        $sumaTotalFebrero = $febreroNac + $febreroIntl;
        $marzoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-03%')->sum("fob");
        $marzoNac = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-03%')->sum("neto");
        $marzoNac = $marzoNac / $valorDolar;
        $sumaTotalMarzo = $marzoNac + $marzoIntl;
        $abrilIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-04%')->sum("fob");
        $abrilNac = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-04%')->sum("neto");
        $abrilNac = $abrilNac / $valorDolar;
        $sumaTotalAbril = $abrilNac + $abrilIntl;
        $mayoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-05%')->sum("fob");
        $mayoNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-05%')->sum("neto");
        $mayoNac  = $mayoNac / $valorDolar;
        $sumaTotalMayo = $mayoNac + $mayoIntl;
        $junioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-06%')->sum("fob");
        $junioNac = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-06%')->sum("neto");
        $junioNac = $junioNac / $valorDolar;
        $sumaTotalJunio = $junioNac + $junioIntl;
        $julioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-07%')->sum("fob");
        $julioNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-07%')->sum("neto");
        $julioNac = $julioNac / $valorDolar;
        $sumaTotalJulio = $julioNac + $julioIntl;
        $agostoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-08%')->sum("fob");
        $agostoNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-08%')->sum("neto");
        $agostoNac = $agostoNac / $valorDolar;
        $sumaTotalAgosto =  $agostoNac + $agostoIntl;
        $septiembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-09%')->sum("fob");
        $septiembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-09%')->sum("neto");
        $septiembreNac = $septiembreNac / $valorDolar;
        $sumaTotalSeptiembre = $septiembreNac + $septiembreIntl;
        $octubreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-10%')->sum("fob");
        $octubreNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-10%')->sum("neto");
        $octubreNac = $octubreNac / $valorDolar;
        $sumaTotalOctubre = $octubreNac + $octubreIntl;
        $noviembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-11%')->sum("fob");
        $noviembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-11%')->sum("neto");
        $noviembreNac = $noviembreNac / $valorDolar;
        $sumaTotalNoviembre = $noviembreNac + $noviembreIntl;
        $diciembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$currentYear.'-12%')->sum("fob");
        $diciembreNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$currentYear.'-12%')->sum("neto");
        $diciembreNac =  $diciembreNac / $valorDolar;
        $sumaTotalDiciembre = $diciembreNac + $diciembreIntl;

        $eneroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-01%')->sum("fob");
        $eneroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-01%')->sum("neto");
        $eneroNac = $eneroNac / $valorDolar;
        $totalLastEnero = $eneroNac + $eneroIntl;
        $febreroIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-02%')->sum("fob");
        $febreroNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-02%')->sum("neto");
        $febreroNac = $febreroNac / $valorDolar;
        $totalLastFebrero = $febreroNac + $febreroIntl;
        $marzoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-03%')->sum("fob");
        $marzoNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-03%')->sum("neto");
        $marzoNac = $marzoNac / $valorDolar;
        $totalLastMarzo = $marzoNac + $marzoIntl;
        $abrilIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-04%')->sum("fob");
        $abrilNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-04%')->sum("neto");
        $abrilNac = $abrilNac / $valorDolar;
        $totalLastAbril = $abrilNac + $abrilIntl;
        $mayoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-05%')->sum("fob");
        $mayoNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-05%')->sum("neto");
        $mayoNac  = $mayoNac / $valorDolar;
        $totalLastMayo = $mayoNac + $mayoIntl;
        $junioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-06%')->sum("fob");
        $junioNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-06%')->sum("neto");
        $junioNac = $junioNac / $valorDolar;
        $totalLastJunio = $junioNac + $junioIntl;
        $julioIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-07%')->sum("fob");
        $julioNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-07%')->sum("neto");
        $julioNac = $julioNac / $valorDolar;
        $totalLastJulio = $julioNac + $julioIntl;
        $agostoIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-08%')->sum("fob");
        $agostoNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-08%')->sum("neto");
        $agostoNac = $agostoNac / $valorDolar;
        $totalLastAgosto =  $agostoNac + $agostoIntl;
        $septiembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-09%')->sum("fob");
        $septiembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-09%')->sum("neto");
        $septiembreNac = $septiembreNac / $valorDolar;
        $totalLastSeptiembre = $septiembreNac + $septiembreIntl;
        $octubreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-10%')->sum("fob");
        $octubreNac  = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-10%')->sum("neto");
        $octubreNac = $octubreNac / $valorDolar;
        $totalLastOctubre = $octubreNac + $octubreIntl;
        $noviembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-11%')->sum("fob");
        $noviembreNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-11%')->sum("neto");
        $noviembreNac = $noviembreNac / $valorDolar;
        $totalLastNoviembre = $noviembreNac + $noviembreIntl;
        $diciembreIntl = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'-12%')->sum("fob");
        $diciembreNac =  FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'-12%')->sum("neto");
        $diciembreNac =  $diciembreNac / $valorDolar;
        $totalLastDiciembre = $diciembreNac + $diciembreIntl;

        //Datos Proyección Ventas
        $presupEneroIntl = VentasMercado::consultaProyeccionIntlEnero($currentYear);
        $presupEneroNac = VentasMercado::consultaProyeccionNacEnero($currentYear);
        $presupEnero = $presupEneroIntl[0]->amount + $presupEneroNac[0]->amount;

        $presupFebreroIntl = VentasMercado::consultaProyeccionIntlFebrero($currentYear);
        $presupFebreroNac = VentasMercado::consultaProyeccionNacFebrero($currentYear);
        $presupFebrero = $presupFebreroIntl[0]->amount + $presupFebreroNac[0]->amount;

        $presupMarzoIntl = VentasMercado::consultaProyeccionIntlMarzo($currentYear);
        $presupMarzoNac = VentasMercado::consultaProyeccionNacMarzo($currentYear);
        $presupMarzo = $presupMarzoIntl[0]->amount + $presupMarzoNac[0]->amount;

        $presupAbrilIntl = VentasMercado::consultaProyeccionIntlAbril($currentYear);
        $presupAbrilNac = VentasMercado::consultaProyeccionNacAbril($currentYear);
        $presupAbril = $presupAbrilIntl[0]->amount + $presupAbrilNac[0]->amount;

        $presupMayoIntl = VentasMercado::consultaProyeccionIntlMayo($currentYear);
        $presupMayoNac = VentasMercado::consultaProyeccionNacMayo($currentYear);
        $presupMayo = $presupMayoIntl[0]->amount + $presupMayoNac[0]->amount;

        $presupJunioIntl = VentasMercado::consultaProyeccionIntlJunio($currentYear);
        $presupJunioNac = VentasMercado::consultaProyeccionNacJunio($currentYear);
        $presupJunio = $presupJunioIntl[0]->amount + $presupJunioNac[0]->amount;

        $presupJulioIntl = VentasMercado::consultaProyeccionIntlJulio($currentYear);
        $presupJulioNac = VentasMercado::consultaProyeccionNacJulio($currentYear);
        $presupJulio = $presupJulioIntl[0]->amount + $presupJulioNac[0]->amount;

        $presupAgostoIntl = VentasMercado::consultaProyeccionIntlAgosto($currentYear);
        $presupAgostoNac = VentasMercado::consultaProyeccionNacAgosto($currentYear);
        $presupAgosto = $presupAgostoIntl[0]->amount + $presupAgostoNac[0]->amount;

        $presupSeptiembreIntl = VentasMercado::consultaProyeccionIntlSeptiembre($currentYear);
        $presupSeptiembreNac = VentasMercado::consultaProyeccionNacSeptiembre($currentYear);
        $presupSeptiembre = $presupSeptiembreIntl[0]->amount + $presupSeptiembreNac[0]->amount;

        $presupOctubreIntl = VentasMercado::consultaProyeccionIntlOctubre($currentYear);
        $presupOctubreNac = VentasMercado::consultaProyeccionNacOctubre($currentYear);
        $presupOctubre = $presupOctubreIntl[0]->amount + $presupOctubreNac[0]->amount;

        $presupNoviembreIntl = VentasMercado::consultaProyeccionIntlNoviembre($currentYear);
        $presupNoviembreNac = VentasMercado::consultaProyeccionNacNoviembre($currentYear);
        $presupNoviembre = $presupNoviembreIntl[0]->amount + $presupNoviembreNac[0]->amount;

        $presupDiciembreIntl = VentasMercado::consultaProyeccionIntlDiciembre($currentYear);
        $presupDiciembreNac = VentasMercado::consultaProyeccionNacDiciembre($currentYear);
        $presupDiciembre = $presupDiciembreIntl[0]->amount + $presupDiciembreNac[0]->amount;


      return view('informes.cierreMes.cierreMesTotal')->with(['data'=>$data,'years' => $years,'yearOptions'=>$yearOptions, 'currentYear' => $currentYear,
                                                              'ventasMesIntl' => $ventasMesIntl, 'totalVentasMesIntl' => $totalVentasMesIntl,
                                                            'cierreMesNovafoods' => $cierreMesNovafoods, 'cierreMesRenova' => $cierreMesRenova,
                                                          'cierreMesWalmart' => $cierreMesWalmart, 'cierreMesMercaNacional' => $cierreMesMercaNacional,
                                                        'cierreMesSumarca' => $cierreMesSumarca, 'valorDolar' => $valorDolar, 'totalVentasMesNac' => $totalVentasMesNac,

              'sumaTotalEnero' => $sumaTotalEnero, 'sumaTotalFebrero' => $sumaTotalFebrero, 'sumaTotalMarzo' => $sumaTotalMarzo, 'sumaTotalAbril' => $sumaTotalAbril,
              'sumaTotalMayo' => $sumaTotalMayo, 'sumaTotalJunio' => $sumaTotalJunio, 'sumaTotalJulio' => $sumaTotalJulio, 'sumaTotalAgosto' => $sumaTotalAgosto,
              'sumaTotalSeptiembre' => $sumaTotalSeptiembre, 'sumaTotalOctubre' => $sumaTotalOctubre, 'sumaTotalNoviembre' => $sumaTotalNoviembre, 'sumaTotalDiciembre' => $sumaTotalDiciembre,

              'totalLastEnero' => $totalLastEnero, 'totalLastFebrero' => $totalLastFebrero, 'totalLastMarzo' => $totalLastMarzo, 'totalLastAbril' => $totalLastAbril,
              'totalLastMayo' => $totalLastMayo, 'totalLastJunio' => $totalLastJunio, 'totalLastJulio' => $totalLastJulio,'totalLastAgosto' => $totalLastAgosto,
              'totalLastSeptiembre' => $totalLastSeptiembre, 'totalLastOctubre' => $totalLastOctubre, 'totalLastNoviembre' => $totalLastNoviembre, 'totalLastDiciembre' => $totalLastDiciembre,

              'presupEnero' => $presupEnero, 'presupFebrero' => $presupFebrero, 'presupMarzo' => $presupMarzo, 'presupAbril' => $presupAbril,
              'presupMayo' => $presupMayo, 'presupJunio' => $presupJunio, 'presupJulio' => $presupJulio, 'presupAgosto' => $presupAgosto,
              'presupSeptiembre' => $presupSeptiembre, 'presupOctubre' => $presupOctubre, 'presupNoviembre' => $presupNoviembre, 'presupDiciembre' => $presupDiciembre]);
    }




    public function reportePorContenedor(Request $request) {

      $dateSelected = $request->dateSelected;

      if (isset($dateSelected))
        {

          $now = Carbon::now();
          $currentYear = $now->year;
          $contenedoresPorCliente = VentasMercado::reportePorContenedor($dateSelected);

        } else {

          $dateSelected = '';
          $now = Carbon::now();
          $currentYear = $now->year;
          $contenedoresPorCliente = [];
          $contenedoresPorClienteLastYear = [];

        }

    return view('informes.ventasPorMes.reportContenedor')->with(['contenedoresPorCliente' => $contenedoresPorCliente,
                                                                'currentYear' => $currentYear,
                                                                'dateSelected' => $dateSelected]);

    }



        public function consultaFacturasIntlByCountry(Request $request) {

          setlocale(LC_ALL, 'es');

          $fechaSelected = $request->dateSelected;
          $lastYear = date('Y-m', strtotime('-1 year', strtotime($fechaSelected)));
          $mesActual = Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
          $mesPasado = Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');

          $sumaTotal = FacturaIntl::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("fob");
          $sumaAnterior = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("fob");

          $yearSelected = Carbon::now()->format('Y');
          $lastYearSelected = Carbon::now()->format('Y') - 1;
          $lastYearSelected = json_encode($lastYearSelected);

          $sumaAcumuladoTotal = FacturaIntl::whereBetween('fecha_emision', [''.$yearSelected.'-01-01', ''.$fechaSelected.'-31'])->sum("fob");
          $sumaAcumuladoAnterior = FacturaIntl::whereBetween('fecha_emision', [''.$lastYearSelected.'-01-01', ''.$lastYear.'-31'])->sum("fob");

          $ventaMesIntl = VentasMercado::consultaFacturasIntlPorPais($lastYear,$fechaSelected,$lastYearSelected,$yearSelected);

          //Data para gráfico
          $sumaTotalEnero = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-01%')->sum("fob");
          $sumaTotalFebrero = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-02%')->sum("fob");
          $sumaTotalMarzo = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-03%')->sum("fob");
          $sumaTotalAbril = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-04%')->sum("fob");
          $sumaTotalMayo = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-05%')->sum("fob");
          $sumaTotalJunio = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-06%')->sum("fob");
          $sumaTotalJulio = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-07%')->sum("fob");
          $sumaTotalAgosto = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-08%')->sum("fob");
          $sumaTotalSeptiembre = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-09%')->sum("fob");
          $sumaTotalOctubre = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-10%')->sum("fob");
          $sumaTotalNoviembre = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-11%')->sum("fob");
          $sumaTotalDiciembre = FacturaIntl::where('fecha_emision', 'like', '%'.$yearSelected.'-12%')->sum("fob");



          $totalLastEnero = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-01%')->sum("fob");
          $totalLastFebrero = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-02%')->sum("fob");
          $totalLastMarzo = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-03%')->sum("fob");
          $totalLastAbril = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-04%')->sum("fob");
          $totalLastMayo = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-05%')->sum("fob");
          $totalLastJunio = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-06%')->sum("fob");
          $totalLastJulio = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-07%')->sum("fob");
          $totalLastAgosto = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-08%')->sum("fob");
          $totalLastSeptiembre = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-09%')->sum("fob");
          $totalLastOctubre = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-10%')->sum("fob");
          $totalLastNoviembre = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-11%')->sum("fob");
          $totalLastDiciembre = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYearSelected.'-12%')->sum("fob");


          return view('informes.ventasPorMes.ventasIntlPorPais')->with(['ventaMesIntl' => $ventaMesIntl, 'mesActual' => $mesActual, 'mesPasado' => $mesPasado, 'sumaTotal' => $sumaTotal, 'yearSelected' => $yearSelected,  'lastYearSelected' => $lastYearSelected, 'sumaAnterior' => $sumaAnterior, 'sumaTotalEnero' => $sumaTotalEnero, 'sumaTotalFebrero' => $sumaTotalFebrero,
          'sumaTotalMarzo' => $sumaTotalMarzo, 'sumaTotalAbril' => $sumaTotalAbril, 'sumaTotalMayo' => $sumaTotalMayo,
          'sumaTotalJunio' => $sumaTotalJunio, 'sumaTotalJulio' => $sumaTotalJulio, 'sumaTotalAgosto' => $sumaTotalAgosto,
          'sumaTotalSeptiembre' => $sumaTotalSeptiembre, 'sumaTotalOctubre' => $sumaTotalOctubre, 'sumaTotalNoviembre' => $sumaTotalNoviembre, 'sumaTotalDiciembre' => $sumaTotalDiciembre,
          'totalLastEnero' => $totalLastEnero, 'totalLastFebrero' => $totalLastFebrero,
          'totalLastMarzo' => $totalLastMarzo, 'totalLastAbril' => $totalLastAbril, 'totalLastMayo' => $totalLastMayo,
          'totalLastJunio' => $totalLastJunio, 'totalLastJulio' => $totalLastJulio, 'totalLastAgosto' => $totalLastAgosto,
          'totalLastSeptiembre' => $totalLastSeptiembre, 'totalLastOctubre' => $totalLastOctubre, 'totalLastNoviembre' => $totalLastNoviembre, 'totalLastDiciembre' => $totalLastDiciembre, 'sumaAcumuladoTotal' => $sumaAcumuladoTotal, 'sumaAcumuladoAnterior' => $sumaAcumuladoAnterior]);
        }



}
