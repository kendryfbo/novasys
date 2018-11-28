<?php

namespace App\Models\Comercial;

use DB;
use App\Models\Comercial\Proforma;
use App\Models\Comercial\CentroVenta;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comercial\FactIntlDetalle;

class FacturaIntl extends Model
{
	protected $table = 'factura_intl';

	protected $fillable = [
    'numero', 'proforma', 'cv_id', 'centro_venta', 'cliente_id', 'cliente', 'fecha_emision', 'fecha_venc',
    'direccion', 'despacho', 'nota', 'transporte', 'puerto_emb', 'puerto_dest', 'forma_pago', 'clau_venta', 'fob',
		'freight', 'insurance','cif', 'descuento','total','user_id', 'deuda'
  ];


  	static function getAllActive() {
  		return self::all();
  	}


	/* registrar Factura apartir de Proforma */
	static function register($request) {


	  $factura = DB::transaction( function() use ($request){

		  $centroVenta = CentroVenta::find($request->centroVenta);

		  $numero = $request->numero;
		  $emision = $request->emision;
		  $vencimiento = $request->vencimiento;
		  $nota = $request->nota;
		  $user = $request->user()->id;
		  $proforma = $request->numero;
		  $cv_id = $centroVenta->id;
		  $centro_venta = $centroVenta->descripcion;
		  $cliente_id = $request->clienteId;
		  $clienteDescrip = $request->clienteDescrip;
		  $direccion = $request->direccion;
		  $despacho = $request->despacho;
		  $transporte = $request->transporte;
		  $puerto_emb = $request->puertoE;
		  $puerto_dest = $request->puertoD;
		  $forma_pago = $request->formaPago;
		  $clau_venta = $request->clausula;
		  $fob = $request->fob;
		  $freight = $request->freight;
		  $insurance = $request->insurance;
		  $cif = 0; // Pendiente por confirmar.
		  $descuento =  0; // Pendiente por confirmar.
		  $total = $request->total;

		  $factura = FacturaIntl::create([
			  'numero' => $numero,
			  'proforma' => $numero,
			  'cv_id' => $cv_id,
			  'centro_venta' => $centro_venta,
			  'cliente_id' => $cliente_id,
			  'cliente' => $clienteDescrip,
			  'fecha_emision' => $emision,
			  'fecha_venc' => $vencimiento,
			  'direccion' => $direccion,
			  'despacho' => $despacho,
			  'nota' => $nota,
			  'transporte' => $transporte,
			  'puerto_emb' => $puerto_emb,
			  'puerto_dest' => $puerto_dest,
			  'forma_pago' => $forma_pago,
			  'clau_venta' => $clau_venta,
			  'fob' => $fob,
			  'freight' => $freight,
			  'insurance' => $insurance,
			  'cif' => $cif,
			  'descuento' => $descuento,
			  'total' => $total,
			  'user_id' => $user
		  ]);
		  foreach ($request->items as $detalle) {

			  $detalle = json_decode($detalle);

			  FactIntlDetalle::Create([
				  'factura_id' => $factura->id,
				  'item' => $detalle->order,
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

		  return $factura;
	  }, 5);

	  return $factura;
	}

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

	static function registerEdit($request,$factura) {

		$numero = $request->numero;
		$fechaEmision = $request->emision;
		$fechaVencimiento = $request->vencimiento;
		$nota = $request->nota;

		$factura->numero = $numero;
		$factura->fecha_emision = $fechaEmision;
		$factura->nota = $nota;
		$factura->fecha_venc = $fechaVencimiento;

		$factura->save();

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
	public function proformaInfo() {

		return $this->belongsTo(Proforma::class,'proforma','numero');
	}


}
