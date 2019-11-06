<?php

namespace App\Models\Comercial;

use DB;
use App\Models\Config\StatusDocumento;
use App\Models\Comercial\NotaCreditoIntlDetalle;
use Illuminate\Database\Eloquent\Model;

class NotaCreditoIntl extends Model
{
    protected $table = 'nota_credito_intl';
    protected $fillable = ['numero', 'num_fact', 'fecha', 'nota', 'neto', 'restante', 'iva', 'iaba', 'total', 'user_id', 'status_id'];

    static function register($request) {

        DB::transaction( function() use ($request) {

            $numero = $request->numero;
            $factura = $request->factura;
            $fecha = $request->fecha;
            $nota = $request->nota;
            $items = $request->items;
            $user = $request->user()->id;

            $totalNeto = 0;
            $totalT = 0;

            $notaCredito = NotaCreditoIntl::create([
                'numero' => $numero,
                'num_fact' => $factura,
                'fecha' => $fecha,
                'nota' => $nota,
                'neto' => $totalNeto,
                'total' => $totalT,
                'restante' => $totalT,  // New Field para Mod. Finanzas Pago Fact. Intl
                'user_id' => $user
            ]);



            foreach ($items as $item) {

                $item = json_decode($item);

                $subtotal = $item->monto;
                $total = $item->monto;

                NotaCreditoIntlDetalle::create([
                    'nc_id' => $notaCredito->id,
                    'prod_id' => '0',
                    'codigo' => 'NO-CODE',
                    'descripcion' => $item->descripcion,
                    'cantidad' => 1,
                    'precio' => $item->monto,
                    'descuento' => 0,
                    'sub_total' => $total
                ]);

                $totalNeto += $subtotal;
                $totalT += $total;
            };

            $notaCredito->neto = $totalNeto;
            $notaCredito->total = $totalT;
            $notaCredito->restante = $totalT;
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

        return $this->hasMany('App\Models\Comercial\NotaCreditoIntlDetalle','nc_id');
    }

}
