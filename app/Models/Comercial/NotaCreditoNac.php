<?php

namespace App\Models\Comercial;

use DB;
use App\Models\Comercial\Impuesto;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comercial\NotaCreditoNacDetalle;
use App\Models\Config\StatusDocumento;

class NotaCreditoNac extends Model
{
    protected $table = 'nota_credito_nac';
    protected $fillable = ['numero', 'fact_id', 'fecha', 'nota', 'neto', 'iva', 'iaba', 'total', 'user_id', 'cliente_id', 'restante'];

    static function getAllUnauthorized() {

        return self::whereNull('aut_comer')->get();
    }

    static function register($request) {

        DB::transaction( function() use ($request) {


            $IVA = Impuesto::where([['id','1'],['nombre','iva']])->pluck('valor')->first();
            $IABA = Impuesto::where([['id','2'],['nombre','iaba']])->pluck('valor')->first();

            $numero = $request->numero;
            $cliente = $request->cliente;
            $facturaID = $request->facturaID;
            $fecha = $request->fecha;
            $nota = $request->nota;
            $items = $request->items;
            $user = $request->user()->id;

            $totalNeto = 0;
            $totalIva = 0;
            $totalIaba = 0;
            $totalT = 0;

            $notaCredito = NotaCreditoNac::create([
                'numero' => $numero,
                'cliente_id' => $cliente,
                'fact_id' => $facturaID,
                'fecha' => $fecha,
                'nota' => $nota,
                'neto' => $totalNeto,
                'iva' => $totalIva,
                'iaba' => $totalIaba,
                'total' => $totalT,
                'restante' => $totalT,
                'user_id' => $user
            ]);



            foreach ($items as $item) {

                $item = json_decode($item);
                $subtotal = $item->precio * $item->cantidad;
                $descuento = 0; // Eliminar de tabla - $subtotal * $item->descuento / 100;
                $neto = $subtotal - $descuento;
                $iva = ($neto * $IVA) / 100;
                $total = $neto + $iva;

                NotaCreditoNacDetalle::create([
                    'nc_id' => $notaCredito->id,
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

                $notaCredito->iaba = 0;

            } else {


                $notaCredito->iaba = ($totalNeto * $IABA)/100;

            }

            $notaCredito->neto = $totalNeto;
            $notaCredito->iva = $totalIva;
            $notaCredito->total = $totalT + $notaCredito->iaba;
            $notaCredito->restante = $totalT + $notaCredito->iaba;
            $notaCredito->save();

        },5);
    }

    /* Public functions */

    public function updateStatus() {

        if ($this->total == $this->restante) {

            $this->status_id = StatusDocumento::pendienteID();
        } else if($this->restante <= 0) {

            $this->status_id = StatusDocumento::completaID();
        } else {

            $this->status_id = StatusDocumento::ingresadaID();
        }

    }


    public function detalles() {

        return $this->hasMany('App\Models\Comercial\NotaCreditoNacDetalle','nc_id');
    }

    public function authorize() {

        $this->aut_comer = 1;
        $this->aut_contab = 1;

        $this->save();
    }

    public function unauthorize() {

        $this->aut_comer = 0;
        $this->aut_contab = 0;

        $this->save();
    }

    /*
	|
	| Relationships
	|
	*/
    public function Factura() {
		return $this->hasOne('App\Models\Comercial\FacturaNacional', 'id', 'fact_id');
	}
    public function clienteNacional()
	{
		return $this->hasOne('App\Models\Comercial\ClienteNacional', 'id', 'cliente_id');
	}
}
