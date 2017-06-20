<?php

namespace App\Repositories\Comercial\NotaVenta;

use App\Models\Comercial\NotaVenta;
use App\Models\Comercial\NotaVentaDetalle;
use DB;
class NotaVentaRepository implements NotaVentaRepositoryInterface {

	const IVA = 19;
	const IABA = 10;

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
			$centroVenta = $request->centroVenta;
			$cliente = $request->cliente;
			$condPago = $request->formaPago;
			$version = $request->version ? $request->version : 1;
			$vendedor = $request->vendedor;
			$despacho = $request->despacho;
			$aut_comer = 0;
			$aut_contab = 0;
			$pesoNeto = $request->peso_neto;
			$pesoBruto = $request->peso_bruto;
			$volumen = $request->volumen;
			$user = 0;
			$fechaEmision = $request->fechaEmision;
			$fechaVenc = $request->fechaVenc;

			$notaVenta = NotaVenta::create([
				'numero' => $numero,
				'cv_id' => $centroVenta,
				'cliente_id' => $cliente,
				'cond_pago' => $condPago,
				'version' => $version,
				'vendedor_id' => $vendedor,
				'despacho' => $despacho,
				'aut_comer' => $aut_comer,
				'aut_contab' => $aut_contab,
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

			$nv = $notaVenta->id;
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
				$iva = ($neto * self::IVA) / 100;
				$iaba = 0;

				if($item->iaba) {

					$iaba = ($neto * self::IABA) / 100;
				}

				NotaVentaDetalle::create([
					'nv_id' => $nv,
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

			$notaVenta->descuento = $totalDescuento;
			$notaVenta->neto = $totalNeto;
			$notaVenta->iva = $totalIva;
			$notaVenta->iaba = $totalIaba;
			$notaVenta->sub_total = $totalSubTotal;
			$notaVenta->total = $total;

			$notaVenta->save();
			
		}, 5);
	}
}
