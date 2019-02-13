<?php

namespace App\Models\Finanzas;

use DB;
use Auth;
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

        /*
        $abonos = AbonoIntl::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->orderBy('fecha_abono')->limit(1)->get();

        $facturas = FacturaIntl::where('cliente_id',$clienteID)->where('cancelada',0)->get();

        $facturaNumero = $facturas->pluck('numero');

        $notaCredito = NotaCreditoIntl::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->orderBy('fecha')->limit(1)->get();

        if ($abonos->isEmpty()) {
            //Sample
            $abonos = AbonoIntl::where('id', 1)->get();
        }
        if ($notaCredito->isEmpty()) {
            //Sample
            $notaCredito = NotaCreditoIntl::where('id', 1)->get();
        }

        $facturas = $request->facturas;
        foreach ($facturas as $factura) {

          $factura = json_decode($factura);

          if (empty($factura->pago)) {
            continue;
          }
          $pago = $factura->pago;

          $factura = FacturaIntl::find($factura->id);

          foreach ($abonos as $abono) {
            $saldoAbono = $abono->restante;

            foreach ($notaCredito as $notaCredit) {



            if ($pago <= $saldoAbono) {
                //dump('if');
                $pagoAbono = PagoIntl::create([
                'factura_id' => $factura->id,
                'usuario_id' => Auth::user()->id,
                'abono_id' => $abono->id,
                'status_id' => 1,
                'numero_documento' => $request->numero_documento,
                'monto' => $pago,
                'saldo' => $factura->deuda - $pago,
                'fecha_pago' => $fecha,
              ]);

              // actualizar factura
              $factura->deuda = $factura->deuda - $pago;
              $factura->updatePago();
              $factura->save();
              //actualizar abono
              $abono->restante = $abono->restante - $request->monto_abonado;
              //dump($abono->monto,$abono->restante);
              //dd($abono);
              $abono->updateStatus();
              $abono->save();
              //actualizar Nota de Crédito
              $notaCredit->restante = $notaCredit->restante - $request->monto_notaCredito;
              $notaCredit->updateStatus();
              $notaCredit->save();
              break;
            } else {
                //dump('else');
                $pagoAbono = PagoIntl::create([
                'factura_id' => $factura->id,
                'usuario_id' => Auth::user()->id,
                'abono_id' => $abono->id,
                'status_id' => 1,
                'numero_documento' => $request->numero_documento,
                'monto' => $pago,
                'saldo' => $factura->deuda - $pago,
                'fecha_pago' => $fecha,
              ]);

              // actualizar factura
              $factura->deuda = $factura->deuda - $pago;
              $factura->updatePago();
              $factura->save();
              //actualizar abono
              $abono->restante = $abono->restante - $request->monto_abonado;
              //dump($abono->monto,$abono->restante);
              //dd($abono);
              $abono->updateStatus();
              $abono->save();
              //actualizar Nota de Crédito
              $notaCredit->restante = $notaCredit->restante - $request->monto_notaCredito;
              $notaCredit->updateStatus();
              $notaCredit->save();
            }
          }
        }
    }
      */
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
        'abono_id' => 1, // PAGO DIRECTO
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
          //actualizar abono
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

        } else if ($pagoNC == $pago->tipo_id) {
          //actualizar Nota Credito
          $notaCredito = NotaCreditoIntl::find($pago->abono_id);
          $notaCredito->restante = $notaCredito->restante + $pago->monto;
          $notaCredito->updateStatus();
          $notaCredito->save();

          // actualizar factura
          $factura = FacturaIntl::find($pago->factura_id);
          $factura->deuda = $factura->deuda + $pago->monto;
          $factura->updatePago();
          $factura->save();
          // Eliminar Pago
          $pago->delete();
        }
      },5);
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
