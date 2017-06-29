<?php

namespace App\Repositories\Comercial\FacturaNacional;

use DB;
use App\Models\Comercial\Impuesto;
use App\Models\Comercial\NotaVenta;
use App\Models\Comercial\FacturaNacional;
use App\Models\Comercial\FacturaNacionalDetalle;

class FacturaNacionalRepository implements FacturaNacionalRepositoryInterface {

	protected $iva,$iaba;

	public function __construct() {

		$this->iva = Impuesto::where([['id','1'],['nombre','iva']])->pluck('valor')->first();
		$this->iaba = Impuesto::where([['id','2'],['nombre','iaba']])->pluck('valor')->first();
	}

	public function register($request) {

		DB::transaction(function () use ($request) {

			$totalDescuento = 0;
			$totalNeto = 0;
			$totalIva = 0;
			$totalIaba = 0;
			$totalSubTotal = 0;
			$total = 0;
			// $subTotal = $request->subtotal;
			// $descuento = $request->descuento;
			// $neto = $request->neto;
			// $iva = $request->iva;
			// $iaba = $request->iaba;
			// $total = $request->total;

			$numero = $request->numero;
			$centroVentaID = $request->centroVenta;
			$centroVentaRut = '';
			$centroVenta = '';
			$clienteID = $request->cliente;
			$clienteRut = '';
			$cliente = '';
			$condPago = $request->formaPago;
			$vendedor = $request->vendedor;
			$despacho = $request->despacho;
			$observacion = $request->observacion;
			// $aut_comer = 0;
			// $aut_contab = 0;
			$pesoNeto = $request->peso_neto;
			$pesoBruto = $request->peso_bruto;
			$volumen = $request->volumen;
			$user = $request->user()->id;
			$fechaEmision = $request->fechaEmision;
			$fechaVenc = $request->fechaVenc;

			$facturaNacional = facturaNacional::create([
				'numero' => $numero,
				'cv_id' => $centroVentaID,
				'cv_rut' => $centroVentaRut,
				'centro_venta' => $centroVenta,
				'cliente_id' => $clienteID,
				'cliente_rut' => $clienteRut,
				'cliente' => $cliente,
				'cond_pago' => $condPago,
				'vendedor_id' => $vendedor,
				'despacho' => $despacho,
				'observacion' => $observacion,
				// 'aut_comer' => $aut_comer,
				// 'aut_contab' => $aut_contab,
				'sub_total' => $totalSubTotal,
				'descuento' => $totalDescuento,
				'neto' => $totalNeto,
				'iva' => $totalIva,
				'iaba' => $totalIaba,
				'total' => $total,
				'peso_neto' => $pesoNeto,
				'peso_bruto' => $pesoBruto,
				'volumen' => $volumen,
				'user_id' => $user,
				'fecha_emision' => $fechaEmision,
				'fecha_venc' => $fechaVenc
			]);

			$nv = $facturaNacional->id;
			$items =  $request->items;
			$i = 0;

			foreach ($items as $item) {

				$i++;

				if ($i > 40) {
					break;
				}
				$item = json_decode($item);

				$id = $item->id;
				$descripcion = $item->descripcion;
				$cantidad = $item->cantidad;
				$precio = $item->precio;
				$porcDesc = $item->descuento;
				$subTotal = $cantidad * $precio;
				$descuento = ($subTotal * $porcDesc) / 100;
				$neto = $subTotal - $descuento;
				$iva = ($neto * $this->iva) / 100;
				$iaba = 0;

				if($item->iaba) {

					$iaba = ($neto * $this->iaba) / 100;
				}

				facturaNacionalDetalle::create([
					'fact_id' => $nv,
					'item' => $i,
					'producto_id' => $id,
					'descripcion' => $descripcion,
					'cantidad' => $cantidad,
					'precio' => $precio,
					'descuento' => $porcDesc,
					'sub_total' => $subTotal
				]);

				$totalSubTotal += $subTotal;
				$totalDescuento += $descuento;
				$totalIva += $iva;
				$totalIaba += $iaba;
				$totalNeto += $neto;
				$total += $neto + $iva + $iaba;

			};

			$facturaNacional->load('centroVenta:id,rut,descripcion', 'clienteNac:id,rut,descripcion', 'vendedor:id,nombre');
			$facturaNacional->cv_rut = $facturaNacional->centroVenta->rut;
			$facturaNacional->centro_venta = $facturaNacional->centroVenta->descripcion;
			$facturaNacional->cliente_rut = $facturaNacional->clienteNac->rut;
			$facturaNacional->cliente = $facturaNacional->clienteNac->descripcion;
			$facturaNacional->vendedor = $facturaNacional->vendedor->nombre;
			$facturaNacional->neto = $totalNeto;
			$facturaNacional->iva = $totalIva;
			$facturaNacional->iaba = $totalIaba;
			$facturaNacional->sub_total = $totalSubTotal;
			$facturaNacional->total = $total;

			$facturaNacional->save();

		}, 5);
	}

	public function registerFromNV($request) {

		DB::transaction(function() use ($request) {

			$notaVentaID = $request->notaVenta;
			$subTotal = $request->subtotal;
			$descuento = $request->descuento;
			$neto = $request->neto;
			$iva = $request->iva;
			$iaba = $request->iaba;
			$total = $request->total;
			$numero = $request->numero;
			$centroVentaId = $request->centroVenta;
			$centroVentaRut = '';
			$centroVenta = '';
			$clienteId = $request->cliente;
			$clienteRut = '';
			$cliente = '';
			$cliente = '';
			$despacho = $request->despacho;
			$condPago = $request->formaPago;
			$observacion = $request->observacion;
			$vendedorId = $request->vendedor;
			$vendedor = $request->vendedor;
			$sub_total = $request->sub_total;
			$descuento = $request->descuento;
			$neto = $request->neto;
			$iva = $request->iva;
			$iaba = $request->iaba;
			$total = $request->total;
			$pesoNeto = $request->peso_neto;
			$pesoBruto = $request->peso_bruto;
			$volumen = $request->volumen;
			$user = $request->user()->id;
			$pagado = 0;
			$fechaEmision = $request->fechaEmision;
			$fechaVenc = $request->fechaVenc;

			$facturaNacional = FacturaNacional::create([
				'numero' => $numero,
				'cv_id' => $centroVentaId,
				'cv_rut' => $centroVentaRut, // FALTA RUT CENTRO VENTA
				'centro_venta' => $centroVenta, // FALTA NOMBRE CENTRO VENTA
				'cliente_id' => $clienteId,
				'cliente_rut' => $clienteRut, // FALTA RUT CLIENTE
				'cliente' => $cliente, // FALTA NOMBRE CLIENTE
				'despacho' => $despacho,
				'cond_pago' => $condPago,
				'observacion' => $observacion,
				'vendedor_id' => $vendedorId,
				'vendedor' => '$vendedor', // FALTA NOMBRE VENDEDOR
				'sub_total' => $subTotal,
				'descuento' => $descuento,
				'neto' => $neto,
				'iva' => $iva,
				'iaba' => $iaba,
				'total' => $total,
				'peso_neto' => $pesoNeto,
				'peso_bruto' => $pesoBruto,
				'volumen' => $volumen,
				'pagado' => $pagado,
				'user_id' => $user,
				'fecha_emision' => $fechaEmision,
				'fecha_venc' => $fechaVenc
			]);

			$factura = $facturaNacional->id;
			$items =  $request->items;
			$i = 0;

			foreach ($items as $item)
			{
				$i++;

				if ($i > 40) {
					break;
				}
				$item = json_decode($item);

				$id = $item->id;
				$descripcion = $item->descripcion;
				$cantidad = $item->cantidad;
				$precio = $item->precio;
				$porcDesc = $item->descuento;
				$subTotal = $item->sub_total;

				FacturaNacionalDetalle::create([
					'fact_id' => $factura,
					'item' => $i,
					'producto_id' => $id,
					'descripcion' => $descripcion,
					'cantidad' => $cantidad,
					'precio' => $precio,
					'descuento' => $porcDesc,
					'sub_total' => $subTotal
				]);

			}

			$notaVenta = NotaVenta::find($notaVentaID);

			$notaVenta->factura = $facturaNacional->numero;
			$notaVenta->save();

		}, 5);
	}
}
