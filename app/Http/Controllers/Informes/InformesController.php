<?php

namespace App\Http\Controllers\Informes;

use DB;
use Excel;
use Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mes;
use App\Models\Comercial\FacturaIntl;
use App\Models\Comercial\FacturaNacional;
use App\Models\Informes\VentasMercado;

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
      $yearSelected = Carbon\Carbon::now()->format('Y');
      $lastYearSelected = Carbon\Carbon::now()->format('Y') - 1;
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
      $mesActual = Carbon\Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon\Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');

      $sumaTotal = FacturaIntl::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("fob");
      $sumaAnterior = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("fob");

      $sumaTotalNac = FacturaNacional::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("neto");
      $sumaTotalNac = ($sumaTotalNac / $valorDolar);
      $sumaAnteriorNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("neto");
      $sumaAnteriorNac = ($sumaAnteriorNac / $valorDolar);

      $yearSelected = Carbon\Carbon::now()->format('Y');
      $lastYearSelected = Carbon\Carbon::now()->format('Y') - 1;
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
      $mesActual = Carbon\Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon\Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');
      $busqueda = $request;

      $sumaTotal = FacturaIntl::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("fob");
      $sumaAnterior = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("fob");

      $sumaTotalNac = FacturaNacional::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("neto");
      $sumaTotalNac = ($sumaTotalNac / $valorDolar);
      $sumaAnteriorNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("neto");
      $sumaAnteriorNac = ($sumaAnteriorNac / $valorDolar);

      $yearSelected = Carbon\Carbon::now()->format('Y');
      $lastYearSelected = Carbon\Carbon::now()->format('Y') - 1;
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
      $mesActual = Carbon\Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon\Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');

      $sumaTotalNac = FacturaNacional::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("neto");
      $sumaTotalNac = ($sumaTotalNac / $valorDolar);
      $sumaAnteriorNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("neto");
      $sumaAnteriorNac = ($sumaAnteriorNac / $valorDolar);

      $yearSelected = Carbon\Carbon::now()->format('Y');
      $lastYearSelected = Carbon\Carbon::now()->format('Y') - 1;
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
      $mesActual = Carbon\Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon\Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');

      $sumaTotal = FacturaIntl::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("fob");
      $sumaAnterior = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("fob");

      $yearSelected = Carbon\Carbon::now()->format('Y');
      $lastYearSelected = Carbon\Carbon::now()->format('Y') - 1;
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
      $mesActual = Carbon\Carbon::parse(''.$fechaSelected.'')->formatLocalized('%B  -  %Y');
      $mesPasado = Carbon\Carbon::parse(''.$lastYear.'')->formatLocalized('%B  -  %Y');

      $sumaTotal = FacturaIntl::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("fob");
      $sumaAnterior = FacturaIntl::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("fob");

      $sumaTotalNac = FacturaNacional::where('fecha_emision', 'like', '%'.$fechaSelected.'%')->sum("neto");
      $sumaTotalNac = ($sumaTotalNac / $valorDolar);
      $sumaAnteriorNac = FacturaNacional::where('fecha_emision', 'like', '%'.$lastYear.'%')->sum("neto");
      $sumaAnteriorNac = ($sumaAnteriorNac / $valorDolar);

      $yearSelected = Carbon\Carbon::now()->format('Y');
      $lastYearSelected = Carbon\Carbon::now()->format('Y') - 1;
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

}
