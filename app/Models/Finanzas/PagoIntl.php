<?php

namespace App\Models\Finanzas;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Finanzas\AbonoIntl;
use App\Models\Comercial\NotaCreditoIntl;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\FacturaIntl;
use App\Models\Config\StatusDocumento;
use Illuminate\Database\Eloquent\Model;

class PagoIntl extends Model
{
    const PAGO_DIRECTO = 1;
    const PAGO_ABONO = 2;
    const PAGO_NC = 3;

    protected $table = 'pagos_intl';

    protected $fillable = ['factura_id', 'usuario_id', 'tipo_id', 'abono_id', 'numero', 'monto', 'saldo', 'fecha_pago'];

    protected $dates = ['fecha_pago', 'expired_at'];


    /*
  	|
  	| Static functions
  	|
  	*/

    static function getAll() {

        return self::all();
    }

    static function register($request) {

      //dd($request->all());
      DB::transaction( function() use($request){

        $pagoDirecto = $request->pago_directo;
        $pagoAbono = $request->pago_abono;
        $pagoNC = $request->pago_nc;

        if ($pagoDirecto) {

          self::registerPagoDirecto($request);

        } else if ($pagoAbono) {

          self::registerPagoAbono($request);

        } else if ($pagoNC) {

          self::registerPagoNC($request);
        }

      },5);
    }

    static function registerPagoDirecto($request) {

      $facturas = $request->facturas;
      $fecha = $request->fecha_hoy;
      $numero = $request->numero_documento;

      $pagoDirectoID = self::getPagoDirectoID();

      foreach ($facturas as $factura) {

        $factura = json_decode($factura);

        if (empty($factura->pago)) {
          continue;
        }
        $pago = $factura->pago;
        $factura = FacturaIntl::find($factura->id);

        // actualizar factura
        $factura->deuda = $factura->deuda - $pago;
        $factura->updatePago();
        $factura->save();

        // crear pago
        $pago = PagoIntl::create([
        'factura_id' => $factura->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoDirectoID,
        'abono_id' => Carbon::now()->format('YmdHis'), // PAGO DIRECTO
        'numero' => $numero,
        'monto' => $pago,
        'saldo' => $factura->deuda,
        'fecha_pago' => $fecha,
        ]);
      }
    }

    static function registerPagoAbono($request) {


      $facturas = $request->facturas;
      $fecha = $request->fecha_hoy;
      $clienteID = $request->clienteID;
      $antAbono = $request->antAbono;
      $statusCompleta = StatusDocumento::completaID();
      $abono = AbonoIntl::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->where('id', $antAbono)->orderBy('fecha_abono')->first();
      $pagoAbonoID = self::getPagoAbonoID();

      foreach ($facturas as $factura) {

        $factura = json_decode($factura);

        if (empty($factura->pago)) {
          continue;
        }

        $pago = $factura->pago;
        $factura = FacturaIntl::find($factura->id);

        // actualizar factura
        $factura->deuda = $factura->deuda - $pago;
        $factura->updatePago();
        $factura->save();
        //actualizar abono
        $abono->restante = $abono->restante - $pago;
        $abono->updateStatus();
        $abono->save();
        // crear pago
        $pago = PagoIntl::create([
        'factura_id' => $factura->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoAbonoID,
        'abono_id' => $abono->id,
        'numero' => $abono->docu_abono,
        'monto' => $pago,
        'saldo' => $factura->deuda,
        'fecha_pago' => $fecha,
        ]);
      }
    }

    static function registerPagoNC($request) {


      $facturas = $request->facturas;
      $fecha = $request->fecha_hoy;
      $notaCred = $request->notaCred;
      $clienteID = $request->clienteID;
      $statusCompleta = StatusDocumento::completaID();
      $factura = FacturaIntl::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('fecha_emision')->get();
      $facturaNumero = $factura->pluck('numero');
      $notasCredito = NotaCreditoIntl::where('id', $notaCred)->where('status_id','!=',$statusCompleta)->orderBy('fecha')->first();
      $pagoNCID = self::getPagoNCID();

      foreach ($facturas as $factura) {

        $factura = json_decode($factura);

        if (empty($factura->pago)) {
          continue;
        }

        $pago = $factura->pago;
        $factura = FacturaIntl::find($factura->id);

        // actualizar factura
        $factura->deuda = $factura->deuda - $pago;
        $factura->updatePago();
        $factura->save();

        //actualizar Nota Crédito
        $notasCredito->restante = $notasCredito->restante - $pago;
        $notasCredito->updateStatus();
        $notasCredito->save();
        // crear pago
        $pago = PagoIntl::create([
        'factura_id' => $factura->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoNCID,
        'abono_id' => $notasCredito->id,
        'numero' => $notasCredito->num_fact,
        'monto' => $pago,
        'saldo' => $factura->deuda,
        'fecha_pago' => $fecha,
        ]);
      }
    }

    static function getPagoDirectoID() {

      return self::PAGO_DIRECTO;
    }
    static function getPagoAbonoID() {

      return self::PAGO_ABONO;
    }
    static function getPagoNCID() {

      return self::PAGO_NC;
    }

    static function unRegister($pagoID) {

      DB::transaction( function() use($pagoID){

        $pagoDirecto = PagoIntl::getPagoDirectoID();
        $pagoAbono = PagoIntl::getPagoAbonoID();
        $pagoNC = PagoIntl::getPagoNCID();

        $pago = PagoIntl::find($pagoID);

        if ($pagoDirecto == $pago->tipo_id) {

          $pagos = PagoIntl::where('tipo_id','=',$pagoDirecto)->where('abono_id','=',$pago->abono_id)->get();

          foreach ($pagos as $pago) {

            // actualizar factura
            $factura = FacturaIntl::find($pago->factura_id);
            $factura->deuda = $factura->deuda + $pago->monto;
            $factura->updatePago();
            $factura->save();
            // Eliminar Pago
            $pago->delete();
          }

        }
        else if ($pagoAbono == $pago->tipo_id) {

          $pagos = PagoIntl::where('tipo_id','=',$pagoAbono)->where('abono_id','=',$pago->abono_id)->get();

          foreach ($pagos as $pago) {
            // actualizar abono
            $abono = AbonoIntl::find($pago->abono_id);
            $abono->restante = $abono->restante + $pago->monto;
            $abono->updateStatus();
            $abono->save();
            // actualizar factura
            $factura = FacturaIntl::find($pago->factura_id);
            $factura->deuda = $factura->deuda + $pago->monto;
            $factura->updatePago();
            $factura->save();
            // Eliminar Pago
            $pago->delete();
          }

        } else if ($pagoNC == $pago->tipo_id) {

          $pagos = PagoIntl::where('tipo_id','=',$pagoNC)->where('abono_id','=',$pago->abono_id)->get();

            foreach ($pagos as $pago) {
              // actualizar Nota Credito
              $notasCredito = NotaCreditoIntl::find($pago->abono_id);
              $notasCredito->restante = $notasCredito->restante + $pago->monto;
              $notasCredito->updateStatus();
              $notasCredito->save();
              // actualizar factura
              $factura = FacturaIntl::find($pago->factura_id);
              $factura->deuda = $factura->deuda + $pago->monto;
              $factura->updatePago();
              $factura->save();
              // Eliminar Pago
              $pago->delete();
            }
        }
      },5);
    }

    static function historialPago($clienteID) {

        $results = FacturaIntl::with('pagos')->with('clienteIntl')->where('cliente_id',$clienteID)->orderBy('numero','ASC')->get();
        return $results;
    }

    static function cuentasCorriente() {

        $results = ClienteIntl::whereHas('facturasIntls')->where('id', '!=', '0')->orderBy('zona','ASC')->orderBy('descripcion','DESC')->get();
        return $results;

    }

    static function facturasPorPagar($clienteID) {

        $results = FacturaIntl::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('cliente','ASC')->orderBy('numero','ASC')->get();
        return $results;
    }

    static function deudasVencidas() {

        $query = "select *,sum(deuda) as deudaTotal from factura_intl where cancelada = 0 group by cliente order by cliente";
        $results = DB::select(DB::raw($query));
        return $results;
    }

    static function deudasVencidasTotal() {

        $query = "select *,sum(deuda) as deudaTotalFacturas from factura_intl where cancelada = 0 order by cliente";
        $results = DB::select(DB::raw($query));
        return $results;
    }


    static function facturasPorPagarTodas() {

        $results = FacturaIntl::where('cancelada',0)->orderBy('cliente','ASC')->orderBy('numero','ASC')->get();
        return $results;
    }

    static function totalesFacturaIntlPorZona() {

        $query = "SELECT a.zona, sum(b.total) as 'totalPorZona', sum(b.deuda) as 'totalDeudaPorZona'
        FROM cliente_intl a, factura_intl b
        WHERE a.id=b.cliente_id
        GROUP BY a.zona
        ORDER BY a.zona ASC";
        $results = DB::select(DB::raw($query));
        return $results;
    }


    /*
	|
	| Relationships
	|
	*/


    public function Factura() {

		return $this->hasOne('App\Models\Comercial\FacturaIntl', 'id', 'factura_id');
	}

    public function clienteIntl()
	{
		return $this->hasOne('App\Models\Comercial\ClienteIntl', 'id', 'cliente_id');
	}

}
