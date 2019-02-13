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

    protected $dates = [
            'fecha_pago'
        ];


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
      $statusCompleta = StatusDocumento::completaID();

      $abono = AbonoIntl::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->orderBy('fecha_abono')->first();

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
      $clienteID = $request->clienteID;
      $statusCompleta = StatusDocumento::completaID();

      $factura = FacturaIntl::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('fecha_emision')->get();
      $facturaNumero = $factura->pluck('numero');
      $notaCredito = NotaCreditoIntl::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->orderBy('fecha')->first();

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
        $notaCredito->restante = $notaCredito->restante - $pago;
        $notaCredito->updateStatus();
        $notaCredito->save();
        // crear pago
        $pago = PagoIntl::create([
        'factura_id' => $factura->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoNCID,
        'abono_id' => $notaCredito->id,
        'numero' => $notaCredito->num_fact,
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

    static function unRegister($identUnico) {

      DB::transaction( function() use($identUnico){

        $pagoDirecto = PagoIntl::getPagoDirectoID();
        $pagoAbono = PagoIntl::getPagoAbonoID();
        $pagoNC = PagoIntl::getPagoNCID();

        $pago = PagoIntl::find($identUnico);

        if ($pagoAbono == $pago->tipo_id) {
          //actualizar abono
          $abono = AbonoIntl::find($pago->abono_id);
          $abono->restante = $abono->restante + $pago->monto;
          $abono->updateStatus();
          $abono->save();

        } else if ($pagoNC == $pago->tipo_id) {
          //actualizar Nota Credito
          $notaCredito = NotaCreditoIntl::find($pago->abono_id);
          $notaCredito->restante = $notaCredito->restante + $pago->monto;
          $notaCredito->updateStatus();
          $notaCredito->save();
        }

        // actualizar factura
        $factura = FacturaIntl::find($pago->factura_id);
        $factura->deuda = $factura->deuda + $pago->monto;
        $factura->updatePago();
        $factura->save();
        // Eliminar Pago
        $pago->delete();
      },5);
    }


    static function historialPago($clienteID) {

        $query = "select b.cancelada, a.numero as 'num_doc', b.numero,a.fecha_pago,'Pago' as 'tipo_doc',0 as cargo,a.monto as abono, 0 as saldo from pagos_intl a, factura_intl b WHERE b.cancelada = '1' AND a.factura_id=b.id AND b.cliente_id=".$clienteID." UNION
        select cancelada,'' as 'num_doc', numero,fecha_emision,'Factura' as 'tipo_doc',total,0 as abono, 0 as saldo from factura_intl where cancelada = '1' AND cliente_id=".$clienteID." ORDER BY  numero,fecha_pago";

        $results = DB::select(DB::raw($query));
        return $results;
    }

        static function facturasPorPagar($clienteID) {

        $query = "select c.zona as zona, b.fecha_venc as 'fecha_venc', b.proforma as 'proforma', b.cliente as 'cliente', b.cancelada, a.numero as 'num_doc', b.numero,a.fecha_pago,'Pago' as 'tipo_doc',0 as cargo,a.monto as abono, 0 as saldo from pagos_intl a, factura_intl b, cliente_intl c WHERE b.cancelada = '0' AND a.factura_id=b.id AND b.cliente_id=c.id AND b.cliente_id=".$clienteID." UNION
        select '' as zona,  fecha_venc as 'fecha_venc', proforma as 'proforma', cliente as 'cliente', cancelada,'' as 'num_doc',numero,fecha_emision,'Factura' as 'tipo_doc',total,0 as abono, 0 as saldo from factura_intl where cancelada = '0' AND cliente_id=".$clienteID." ORDER BY numero,fecha_pago";

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
