<?php

namespace App\Models\Finanzas;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Finanzas\AbonoNacional;
use App\Models\Finanzas\ChequeCartera;
use App\Models\Comercial\NotaCreditoNac;
use App\Models\Comercial\NotaDebitoNac;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FacturaNacional;
use App\Models\Config\StatusDocumento;
use Illuminate\Database\Eloquent\Model;
class PagoNacional extends Model
{
    const PAGO_DIRECTO = 1;
    const PAGO_ABONO = 2;
    const PAGO_NC = 3;
    protected $table = 'pagos_nacional';
    protected $fillable = ['factura_id', 'notaDebito_id', 'usuario_id', 'tipo_id', 'abono_id', 'numero', 'monto', 'saldo', 'fecha_pago', 'formaPago_id', 'banco_id'];
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
      $notasDebito = $request->notasDebito;

      $fecha = $request->fecha_hoy;
      $fechaCobro = $request->fecha_cobro;
      $numero = $request->numero_documento;
      $formaPago = $request->formaPago;
      $banco = $request->banco;
      $pagoDirectoID = self::getPagoDirectoID();

      foreach ($facturas as $factura) {
        $factura = json_decode($factura);
        if (empty($factura->pago)) {
          continue;
        }
        $pago = $factura->pago;
        $factura = FacturaNacional::find($factura->id);
        // actualizar factura
        $factura->deuda = $factura->deuda - $pago;
        $factura->updatePago();
        $factura->save();
        // crear pago
        $pago = PagoNacional::create([
        'factura_id' => $factura->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoDirectoID,
        'abono_id' => Carbon::now()->format('YmdHis'), // PAGO DIRECTO
        'numero' => $numero,
        'monto' => $pago,
        'saldo' => $factura->deuda,
        'fecha_pago' => $fecha,
        'formaPago_id' => $formaPago,
        'banco_id' => $banco,
        ]);

        //Si cliente paga con cheque se guarda Cheque en Cartera
        if ($formaPago == 1 || $formaPago == 2) {
        ChequeCartera::create([
  				  'cliente_id' => $factura->cliente_id,
                  'banco_id' => $banco,
                  'abono_id' => Carbon::now()->format('YmdHis'),
                  'numero_cheque' => $numero,
                  'monto' => $pago->monto,
  				  'fecha_cobro' => $fechaCobro,
                  'aut_cobro' => 0,
                  'usuario_id' => Auth::user()->id,
		]);

        }

      }

      if (empty($notasDebito)) {

                } else {

      foreach ($notasDebito as $notaDebito) {
        $notaDebito = json_decode($notaDebito);
        if (empty($notaDebito->pago)) {
          continue;
        }
        $pago = $notaDebito->pago;
        $notaDebito = NotaDebitoNac::find($notaDebito->id);
        // actualizar Nota Débito
        $notaDebito->deuda = $notaDebito->deuda - $pago;
        $notaDebito->updatePagoND();
        $notaDebito->save();
        // crear pago
        $pago = PagoNacional::create([
        'factura_id' => $notaDebito->factura_id,
        'notaDebito_id' => $notaDebito->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoDirectoID,
        'abono_id' => Carbon::now()->format('YmdHis'), // PAGO DIRECTO
        'numero' => $numero,
        'monto' => $pago,
        'saldo' => $notaDebito->deuda,
        'fecha_pago' => $fecha,
        'formaPago_id' => $formaPago,
        'banco_id' => $banco,
        ]);

        //Si cliente paga con cheque se guarda Cheque en Cartera
        if ($formaPago == 1 || $formaPago == 2) {
        ChequeCartera::create([
                  'cliente_id' => $factura->cliente_id,
                  'banco_id' => $banco,
                  'abono_id' => Carbon::now()->format('YmdHis'),
                  'numero_cheque' => $numero,
                  'monto' => $pago->monto,
                  'fecha_cobro' => $fechaCobro,
                  'aut_cobro' => 0,
                  'usuario_id' => Auth::user()->id,
        ]);

        }

        }

      }
    }

    static function registerPagoAbono($request) {
      $facturas = $request->facturas;
      $notasDebito = $request->notasDebito;
      $fechaCobro = $request->fecha_cobro;
      $numero = $request->numero_documento;
      $formaPago = $request->formaPago;
      $banco = $request->banco;
      $fecha = $request->fecha_hoy;
      $clienteID = $request->clienteID;
      $antAbono = $request->antAbono;
      $statusCompleta = StatusDocumento::completaID();
      $abono = AbonoNacional::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->where('id', $antAbono)->orderBy('fecha_abono')->first();
      $pagoAbonoID = self::getPagoAbonoID();
      $formaPago = $request->formaPago;
      $banco = $request->banco;
      foreach ($facturas as $factura) {
        $factura = json_decode($factura);
        if (empty($factura->pago)) {
          continue;
        }
        $pago = $factura->pago;
        $factura = FacturaNacional::find($factura->id);
        // actualizar factura
        $factura->deuda = $factura->deuda - $pago;
        $factura->updatePago();
        $factura->save();
        //actualizar abono
        $abono->restante = $abono->restante - $pago;
        $abono->updateStatus();
        $abono->save();
        // crear pago
        $pago = PagoNacional::create([
        'factura_id' => $factura->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoAbonoID,
        'abono_id' => $abono->id,
        'numero' => $abono->docu_abono,
        'monto' => $pago,
        'saldo' => $factura->deuda,
        'fecha_pago' => $fecha,
        'formaPago_id' => $formaPago,
        'banco_id' => $banco,
        ]);
      }

      if (empty($notasDebito)) {

                } else {

      foreach ($notasDebito as $notaDebito) {
        $notaDebito = json_decode($notaDebito);
        if (empty($notaDebito->pago)) {
          continue;
        }
        $pago = $notaDebito->pago;
        $notaDebito = NotaDebitoNac::find($notaDebito->id);
        // actualizar Nota Débito
        $notaDebito->deuda = $notaDebito->deuda - $pago;
        $notaDebito->updatePagoND();
        $notaDebito->save();
        //actualizar abono
        $abono->restante = $abono->restante - $pago;
        $abono->updateStatus();
        $abono->save();
        // crear pago
        $pago = PagoNacional::create([
        'factura_id' => $notaDebito->factura_id,
        'notaDebito_id' => $notaDebito->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoAbonoID,
        'abono_id' => $abono->id,
        'numero' => $numero,
        'monto' => $pago,
        'saldo' => $notaDebito->deuda,
        'fecha_pago' => $fecha,
        'formaPago_id' => $formaPago,
        'banco_id' => $banco,
        ]);

        }

       }
    }
    static function registerPagoNC($request) {
      $facturas = $request->facturas;
      $notasDebito = $request->notasDebito;
      $fecha = $request->fecha_hoy;
      $formaPago = $request->formaPago;
      $banco = $request->banco;
      $notaCred = $request->notaCred;
      $numero = $request->numero_documento;
      $clienteID = $request->clienteID;
      $statusCompleta = StatusDocumento::completaID();
      $factura = FacturaNacional::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('fecha_emision')->get();
      $facturaNumero = $factura->pluck('numero');
      $notasCredito = NotaCreditoNac::where('id', $notaCred)->where('status_id','!=',$statusCompleta)->orderBy('fecha')->first();
      $pagoNCID = self::getPagoNCID();
      $formaPago = $request->formaPago;
      $banco = $request->banco;
      foreach ($facturas as $factura) {
        $factura = json_decode($factura);
        if (empty($factura->pago)) {
          continue;
        }
        $pago = $factura->pago;
        $factura = FacturaNacional::find($factura->id);
        // actualizar factura
        $factura->deuda = $factura->deuda - $pago;
        $factura->updatePago();
        $factura->save();
        //actualizar Nota Crédito
        $notasCredito->restante = $notasCredito->restante - $pago;
        $notasCredito->updateStatus();
        $notasCredito->save();
        // crear pago
        $pago = PagoNacional::create([
        'factura_id' => $factura->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoNCID,
        'abono_id' => $notasCredito->id,
        'numero' => 'NC '.$notasCredito->numero.'',
        'monto' => $pago,
        'saldo' => $factura->deuda,
        'fecha_pago' => $fecha,
        'formaPago_id' => $formaPago,
        'banco_id' => $banco,
        ]);
      }

      if (empty($notasDebito)) {

                } else {

      foreach ($notasDebito as $notaDebito) {
        $notaDebito = json_decode($notaDebito);
        if (empty($notaDebito->pago)) {
          continue;
        }
        $pago = $notaDebito->pago;
        $notaDebito = NotaDebitoNac::find($notaDebito->id);
        // actualizar Nota Débito
        $notaDebito->deuda = $notaDebito->deuda - $pago;
        $notaDebito->updatePagoND();
        $notaDebito->save();
        //actualizar Nota Crédito
        $notasCredito->restante = $notasCredito->restante - $pago;
        $notasCredito->updateStatus();
        $notasCredito->save();
        // crear pago
        $pago = PagoNacional::create([
        'factura_id' => $notaDebito->factura_id,
        'notaDebito_id' => $notaDebito->id,
        'usuario_id' => Auth::user()->id,
        'tipo_id' => $pagoNCID,
        'abono_id' => $notasCredito->id,
        'numero' => 'NC '.$notasCredito->numero.'',
        'monto' => $pago,
        'saldo' => $notaDebito->deuda,
        'fecha_pago' => $fecha,
        'formaPago_id' => $formaPago,
        'banco_id' => $banco,
        ]);

       }

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
        $pagoDirecto = PagoNacional::getPagoDirectoID();
        $pagoAbono = PagoNacional::getPagoAbonoID();
        $pagoNC = PagoNacional::getPagoNCID();
        $pago = PagoNacional::find($pagoID);
        if ($pagoDirecto == $pago->tipo_id) {
          $pagos = PagoNacional::where('tipo_id','=',$pagoDirecto)->where('abono_id','=',$pago->abono_id)->get();
          // Borrar Cheque en Cartera

          $chequeCartera = ChequeCartera::where('abono_id','=',$pago->abono_id)->get();

          foreach ($chequeCartera as $pagoChequeCartera) {
                  $pagoChequeCartera->delete();
          }
          foreach ($pagos as $pago) {

              if(isset($pago->notaDebito_id)) {

              //actualiza Nota Débito
              $notaDebito = NotaDebitoNac::find($pago->notaDebito_id);
              $notaDebito->deuda = $notaDebito->deuda + $pago->monto;
              $notaDebito->updatePagoND();
              $notaDebito->save();
              // Eliminar Pago
              $pago->delete();

          } else {

            // actualizar factura
            $factura = FacturaNacional::find($pago->factura_id);
            $factura->deuda = $factura->deuda + $pago->monto;
            $factura->updatePago();
            $factura->save();
            // Eliminar Pago
            $pago->delete();
            }
        }
    }
        else if ($pagoAbono == $pago->tipo_id) {
          $pagos = PagoNacional::where('tipo_id','=',$pagoAbono)->where('abono_id','=',$pago->abono_id)->get();

          foreach ($pagos as $pago) {
            // actualizar abono
            $abono = AbonoNacional::find($pago->abono_id);
            $abono->restante = $abono->restante + $pago->monto;
            $abono->updateStatus();
            $abono->save();

            if(isset($pago->notaDebito_id)) {

            //actualiza Nota Débito
            $notaDebito = NotaDebitoNac::find($pago->notaDebito_id);
            $notaDebito->deuda = $notaDebito->deuda + $pago->monto;
            $notaDebito->updatePagoND();
            $notaDebito->save();
            // Eliminar Pago
            $pago->delete();

        } else {
            // actualizar factura
            $factura = FacturaNacional::find($pago->factura_id);
            $factura->deuda = $factura->deuda + $pago->monto;
            $factura->updatePago();
            $factura->save();
            // Eliminar Pago
            $pago->delete();
          }

        }

        } else if ($pagoNC == $pago->tipo_id) {
          $pagos = PagoNacional::where('tipo_id','=',$pagoNC)->where('abono_id','=',$pago->abono_id)->get();
            foreach ($pagos as $pago) {
              // actualizar Nota Credito
              $notasCredito = NotaCreditoNac::find($pago->abono_id);
              $notasCredito->restante = $notasCredito->restante + $pago->monto;
              $notasCredito->updateStatus();
              $notasCredito->save();


              if(isset($pago->notaDebito_id)) {

              //actualiza Nota Débito
              $notaDebito = NotaDebitoNac::find($pago->notaDebito_id);
              $notaDebito->deuda = $notaDebito->deuda + $pago->monto;
              $notaDebito->updatePagoND();
              $notaDebito->save();
              // Eliminar Pago
              $pago->delete();

            } else {

            // actualizar factura
            $factura = FacturaNacional::find($pago->factura_id);
            $factura->deuda = $factura->deuda + $pago->monto;
            $factura->updatePago();
            $factura->save();
            // Eliminar Pago
            $pago->delete();
            }
          }
        }
      },5);
    }
    static function historialPago($clienteID) {
        $results = FacturaNacional::with('notasDebito')->where('cliente_id',$clienteID)->orderBy('numero','ASC')->get();
        return $results;
    }
    static function totalNotaDebito($clienteID) {
        $query = "SELECT sum(b.total) AS 'totalNotaDebito', sum(b.deuda) AS 'deudaNotaDebito' FROM factura_nacional a, nota_debito_nac b, cliente_nacional c WHERE a.id=b.factura_id AND c.id=a.cliente_id AND c.id='.$clienteID.'";
        $results = DB::select(DB::raw($query));
        return $results;
    }
    static function totalNotaDebitoNull($clienteID) {
        $query = "SELECT sum(nota_debito_nac.total) AS 'totalNotaDebito', sum(nota_debito_nac.deuda) AS 'deudaNotaDebito' FROM factura_nacional INNER JOIN nota_debito_nac ON factura_nacional.id=nota_debito_nac.factura_id INNER JOIN cliente_nacional ON factura_nacional.cliente_id=cliente_nacional.id where cliente_nacional.id = '".$clienteID."'";
        $results = DB::select(DB::raw($query));
        return $results;
    }

    static function cuentasCorriente($clienteID) {
        $results = ClienteNacional::whereHas('facturasNac')->where('id',$clienteID)->orderBy('descripcion','ASC')->get();
        return $results;
    }

    static function cuentasCorrienteTodas() {
        $results = ClienteNacional::whereHas('facturasNac')->orderBy('descripcion','ASC')->get();
        return $results;
    }
    static function facturasPorPagar($clienteID) {
        $results = FacturaNacional::with('notasDebito')->where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('cliente','ASC')->orderBy('numero','ASC')->get();
        return $results;
    }

    static function facturasPorPagarTodas() {
        $results = FacturaNacional::with('notasDebito')->where('cancelada',0)->orderBy('cliente','ASC')->orderBy('numero','ASC')->get();
        return $results;
    }

    /*
	|
	| Relationships
	|
	*/
    public function Factura() {
		return $this->hasOne('App\Models\Comercial\FacturaNacional', 'id', 'factura_id');
	}
    public function clienteNacional()
	{
		return $this->hasOne('App\Models\Comercial\ClienteNacional', 'id', 'cliente_id');
	}
    public function formaPago()
    {
        return $this->hasOne('App\Models\Finanzas\FormaPago', 'id', 'formaPago_id');
    }
}
