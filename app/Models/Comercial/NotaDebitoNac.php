<?php

namespace App\Models\Comercial;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comercial\FacturaNacional;
use App\Models\Comercial\NotaDebitoNacDetalle;
use App\Models\Config\StatusDocumento;

class NotaDebitoNac extends Model
{
    protected $table = 'nota_debito_nac';
    protected $fillable = ['numero', 'status_id', 'factura_id', 'fecha', 'nota', 'neto', 'iva', 'iaba', 'total', 'deuda', 'user_id'];


    static function register($request) {

        return $notaDebito = DB::transaction (function() use($request) {


            $IVA = Impuesto::where([['id','1'],['nombre','iva']])->pluck('valor')->first();
            $IABA = Impuesto::where([['id','2'],['nombre','iaba']])->pluck('valor')->first();
            $factura = FacturaNacional::where('numero',$request->factura)->first();

            $numero = $request->numero;
            $fecha = $request->fecha;
            $nota = $request->nota;
            $items = $request->items;
            $user = $request->user()->id;

            $totalNeto = 0;
            $totalIva = 0;
            $totalIaba = 0;
            $totalT = 0;

            $notaDebito = notaDebitoNac::create([
                'numero' => $numero,
                'status_id' => 1,
                'factura_id' => $factura->id,
                'fecha' => $fecha,
                'nota' => $nota,
                'neto' => $totalNeto,
                'iva' => $totalIva,
                'iaba' => $totalIaba,
                'total' => $totalT,
                'deuda' => $totalT,
                'user_id' => $user
            ]);



            foreach ($items as $item) {

                $item = json_decode($item);
                $subtotal = $item->precio * $item->cantidad;
                $descuento = 0; // Eliminar de tabla - $subtotal * $item->descuento / 100;
                $neto = $subtotal - $descuento;
                $iva = ($neto * $IVA) / 100;
                $total = $neto + $iva;

                notaDebitoNacDetalle::create([
                    'nd_id' => $notaDebito->id,
                    'prod_id' => $item->producto_id,
                    'codigo' => 'NO-CODE',
                    'descripcion' => $item->descripcion,
                    'cantidad' => $item->cantidad,
                    'precio' => $item->precio,
                    'descuento' => $descuento,
                    'sub_total' => $total
                ]);

                $totalNeto += $neto;
                $totalIva += $iva;
                $totalT += $total;
            };

            $statusIABA = $request->statusIABA;

            if ($statusIABA == NULL) {

                $notaDebito->iaba = 0;

            } else {


                $notaDebito->iaba = ($totalNeto * $IABA)/100;

            }

            $notaDebito->neto = $totalNeto;
            $notaDebito->iva = $totalIva;
            $notaDebito->total = $totalT + $notaDebito->iaba;
            $notaDebito->deuda = $totalT + $notaDebito->iaba;
            $notaDebito->save();

            return $notaDebito;
        },5);

    }

    /* Public functions */

    public function updatePagoND() {

        if ($this->total == $this->deuda) {

            $this->status_id = StatusDocumento::pendienteID();
        } else if($this->deuda <= 0) {

            $this->status_id = StatusDocumento::completaID();
        } else {

            $this->status_id = StatusDocumento::ingresadaID();
        }

    }


    public function detalles() {

        return $this->hasMany('App\Models\Comercial\NotaDebitoNacDetalle','nd_id');
    }



}
