<?php

namespace App\Models\Comercial;

use DB;
use App\Models\Comercial\Proforma;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comercial\FactIntlDetalle;

class FacturaIntl extends Model
{
	protected $table = 'factura_intl';

	protected $fillable = [
    'numero', 'proforma', 'cv_id', 'centro_venta', 'cliente_id', 'cliente', 'fecha_emision', 'fecha_venc',
    'direccion', 'despacho', 'nota', 'transporte', 'puerto_emb', 'puerto_dest', 'forma_pago', 'clau_venta', 'fob',
		'freight', 'insurance','cif', 'descuento','total','user_id'
  ];

	/* registrar Factura apartir de Proforma */
	static function regFromProforma($request,$proforma) {


		$factura = DB::transaction( function() use ($request,$proforma){

			$numero = $request->numero;
			$emision = $request->emision;
			$vencimiento = $request->vencimiento;
			$nota = $request->nota;
			$user = $request->user()->id;
			$proforma = Proforma::with('detalles','cliente')->find($proforma);

			$factura = FacturaIntl::create([
				'numero' => $numero,
				'proforma' => $proforma->numero,
				'cv_id' => $proforma->cv_id,
				'centro_venta' => $proforma->centro_venta,
				'cliente_id' => $proforma->cliente_id,
				'cliente' => $proforma->cliente->descripcion,
				'fecha_emision' => $emision,
				'fecha_venc' => $vencimiento,
				'direccion' => $proforma->direccion,
				'despacho' => $proforma->despacho,
				'nota' => $nota,
				'transporte' => $proforma->transporte,
				'puerto_emb' => $proforma->puerto_emb,
				'puerto_dest' => $proforma->puerto_dest,
				'forma_pago' => $proforma->forma_pago,
				'clau_venta' => $proforma->clau_venta,
				'fob' => $proforma->fob,
				'freight' => $proforma->freight,
				'insurance' => $proforma->insurance,
				'cif' => $proforma->cif,
				'descuento' => $proforma->descuento,
				'total' => $proforma->total,
				'user_id' => $user
			]);

			foreach ($proforma->detalles as $detalle) {

				FactIntlDetalle::Create([
					'factura_id' => $factura->id,
					'item' => $detalle->item,
					'producto_id' => $detalle->producto_id,
					'codigo' => $detalle->codigo,
					'descripcion' => $detalle->descripcion,
					'cantidad' => $detalle->cantidad,
					'precio' => $detalle->precio,
					'descuento' => $detalle->descuento,
			    	'sub_total' => $detalle->sub_total,
					'peso_neto' => $detalle->peso_neto,
					'peso_bruto' => $detalle->peso_bruto,
					'volumen' => $detalle->volumen
				]);
			}

			$proforma->factura = $factura->numero;
			$proforma->save();

			return $factura;
		}, 5);

		return $factura;
	}

	/*
	|
	|	Relationships
	|
	*/

	public function detalles() {

		return $this->hasMany(FactIntlDetalle::class,'factura_id');
	}

	public function clienteIntl() {

		return $this->belongsTo(ClienteIntl::class,'cliente_id');
	}
	public function centroVenta() {

		return $this->belongsTo(CentroVenta::class,'cv_id');
	}


}
