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
    protected $table = 'pagos_intl';

    protected $fillable = ['factura_id', 'monto', 'saldo', 'numero_documento', 'fecha_pago', 'usuario_id', 'abono_id'];

    protected $dates = [
            'fecha_pago'
        ];
    static function getAll() {

        return self::all();
    }

    static function register($request) {

      //dd($request->all());
      DB::transaction( function() use($request){

        $fecha = $request->fecha_hoy;
        $clienteID = $request->clienteID;
        $statusPendiente = StatusDocumento::pendienteID();
        $statusCompleta = StatusDocumento::completaID();

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
        //dd('end');
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
