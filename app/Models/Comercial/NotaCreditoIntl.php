<?php

namespace App\Models\Comercial;

use DB;
use App\Models\Comercial\NotaCreditoIntlDetalle;
use Illuminate\Database\Eloquent\Model;

class NotaCreditoIntl extends Model
{
    protected $table = 'nota_credito_intl';
    protected $fillable = ['numero', 'num_fact', 'fecha', 'nota', 'neto', 'iva', 'iaba', 'total', 'user_id'];

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

            $notaCredito->save();

        },5);
    }

    public function detalles() {

        return $this->hasMany('App\Models\Comercial\NotaCreditoIntlDetalle','nc_id');
    }
}
