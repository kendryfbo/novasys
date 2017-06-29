<?php

namespace App\Repositories\Comercial\FacturaNacional;

use App\Models\Comercial\FacturaNacional;
use App\Models\Comercial\FacturaNacionalDetalle;
use DB;

class FacturaNacionalRepository implements FacturaNacionalRepositoryInterface {

	public function __construct() {

	}

	public function register($request) {

		DB::transaction(function() use ($request) {

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
			$user = 0;
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

			};

		}, 5);
	}
}
