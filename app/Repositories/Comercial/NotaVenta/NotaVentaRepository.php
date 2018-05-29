<?php

namespace App\Repositories\Comercial\NotaVenta;

use App\Models\Comercial\Impuesto;
use App\Models\Comercial\NotaVenta;
use App\Models\Comercial\NotaVentaDetalle;
use DB;
class NotaVentaRepository implements NotaVentaRepositoryInterface {

	protected $iva,$iaba,$numero;

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
			$totalPesoNeto = 0;
			$totalPesoBruto = 0;
			$totalVolumen = 0;

			$numero = NotaVenta::orderBy('numero','desc')->pluck('numero')->first();
			if (is_null($numero)) {

				$numero = 1;

			} else {

				$numero++;
			};

			$centroVenta = $request->centroVenta;
			$cliente = $request->cliente;
			$condPago = $request->formaPago;
			$version = $request->version ? $request->version : 1;
			$vendedor = $request->vendedor;
			$ordenCompra = $request->orden_compra;
			$direccion = $request->direccion;
			$despacho = $request->despacho;
			$user = $request->user()->id;
			$fechaEmision = $request->fechaEmision;
			$fechaDespacho = $request->fechaDespacho;

			$notaVenta = NotaVenta::create([
				'numero' => $numero,
				'cv_id' => $centroVenta,
				'cliente_id' => $cliente,
				'cond_pago' => $condPago,
				'version' => $version,
				'vendedor_id' => $vendedor,
				'orden_compra' => $ordenCompra,
				'direccion' => $direccion,
				'despacho' => $despacho,
				'sub_total' => $totalSubTotal,
				'descuento' => $totalDescuento,
				'neto' => $totalNeto,
				'iva' => $totalIva,
				'iaba' => $totalIaba,
				'total' => $total,
				'peso_neto' => $totalPesoNeto,
				'peso_bruto' => $totalPesoBruto,
				'volumen' => $totalVolumen,
				'user_id' => $user,
				'fecha_emision' => $fechaEmision,
				'fecha_despacho' => $fechaDespacho
			]);

			$nv = $notaVenta->id;
			$items =  $request->items;
			$detalleNV = [];
			$i = 0;

			foreach ($items as $item) {

				$i++;

				if ($i > 40) {
					break;
				}
				$item = json_decode($item);

				$id = $item->id;
				$codigo = $item->codigo;
				$descripcion = $item->descripcion;
				$cantidad = $item->cantidad;
				$precio = $item->precio;
				$porcDesc = $item->descuento;
				$pesoNeto = $item->peso_neto;
				$pesoBruto = $item->peso_bruto;
				$volumen = $item->volumen;

				$subTotal = $cantidad * $precio;
				$descuento = ($subTotal * $porcDesc) / 100;
				$neto = $subTotal - $descuento;
				$iva = ($neto * $this->iva) / 100;
				$iaba = 0;

				if($item->iaba) {

					$iaba = ($neto * $this->iaba) / 100;
				}

				$detalleNV[] = [
					'nv_id' => $nv,
					'item' => $i,
					'producto_id' => $id,
					'codigo' => $codigo,
					'descripcion' => $descripcion,
					'cantidad' => $cantidad,
					'precio' => $precio,
					'descuento' => $porcDesc,
					'sub_total' => $subTotal
				];

				$totalSubTotal += $subTotal;
				$totalDescuento += $descuento;
				$totalIva += $iva;
				$totalIaba += $iaba;
				$totalNeto += $neto;
				$total += $neto + $iva + $iaba;
				$totalPesoNeto += $pesoNeto;
				$totalPesoBruto += $pesoBruto;
				$totalVolumen += $volumen;

			};

			foreach ($detalleNV as $detalle) {

				NotaVentaDetalle::create($detalle);
			}

			$notaVenta->descuento = $totalDescuento;
			$notaVenta->neto = $totalNeto;
			$notaVenta->iva = $totalIva;
			$notaVenta->iaba = $totalIaba;
			$notaVenta->sub_total = $totalSubTotal;
			$notaVenta->total = $total;
			$notaVenta->peso_neto = $totalPesoNeto;
			$notaVenta->peso_bruto = $totalPesoBruto;
			$notaVenta->volumen = $totalVolumen;

			$notaVenta->save();

			$this->numero = $notaVenta->numero;

		}, 5);

		return $this->numero;
	}

	public function registerEdit($request,$notaVenta) {

		DB::transaction(function () use ($request,$notaVenta) {

			$detalleNV = [];

			$totalDescuento = 0;
			$totalNeto = 0;
			$totalIva = 0;
			$totalIaba = 0;
			$totalSubTotal = 0;
			$total = 0;
			$totalPesoNeto = 0;
			$totalPesoBruto = 0;
			$totalVolumen = 0;

			$nv = $notaVenta->id;
			$items =  $request->items;
			$i = 0;

			foreach ($items as $item) {

				// LIMITE DE ITEMS POR NOTA DE VENTA
				$i++;
				if ($i > 40) {
					break;
				}

				$item = json_decode($item);

				$id = $item->producto_id;
				$codigo = $item->codigo;
				$descripcion = $item->descripcion;
				$cantidad = $item->cantidad;
				$precio = $item->precio;
				$porcDesc = $item->descuento;
				$pesoNeto = 0; // Corregir error -> no se esta recibiendo este dato = $item->peso_neto;
				$pesoBruto = 0; // Corregir error -> no se esta recibiendo este dato = $item->peso_bruto;
				$volumen = 0; // Corregir error -> no se esta recibiendo este dato = $item->volumen;

				$subTotal = $cantidad * $precio;
				$descuento = ($subTotal * $porcDesc) / 100;
				$neto = $subTotal - $descuento;
				$iva = ($neto * $this->iva) / 100;
				$iaba = 0;

				// corregir Error -> No se esta recibiendo este dato = $item->iaba
				// if($item->iaba) {
				if(false) {
					$iaba = ($neto * $this->iaba) / 100;

				} else {

					$iaba = 0;

				}

				$detalleNV[] = [
					'nv_id' => $nv,
					'item' => $i,
					'producto_id' => $id,
					'codigo' => $codigo,
					'descripcion' => $descripcion,
					'cantidad' => $cantidad,
					'precio' => $precio,
					'descuento' => $porcDesc,
					'sub_total' => $subTotal
				];

				$totalSubTotal += $subTotal;
				$totalDescuento += $descuento;
				$totalIva += $iva;
				$totalIaba += $iaba;
				$totalNeto += $neto;
				$total += $neto + $iva + $iaba;
				$totalPesoNeto += $pesoNeto;
				$totalPesoBruto += $pesoBruto;
				$totalVolumen += $volumen;

			};

			$notaVenta->cv_id = $request->centroVenta;
			$notaVenta->version = $notaVenta->version + 1;
			$notaVenta->vendedor_id = $request->vendedor;
			$notaVenta->orden_compra = $request->orden_compra;
			$notaVenta->despacho = $request->despacho;
			$notaVenta->direccion = $request->direccion;
			$notaVenta->user_id = $request->user()->id;
			$notaVenta->fecha_emision = $request->fechaEmision;
			$notaVenta->fecha_despacho = $request->fechaDespacho;
			$notaVenta->descuento = $totalDescuento;
			$notaVenta->neto = $totalNeto;
			$notaVenta->iva = $totalIva;
			$notaVenta->iaba = $totalIaba;
			$notaVenta->sub_total = $totalSubTotal;
			$notaVenta->total = $total;
			$notaVenta->peso_neto = $totalPesoNeto;
			$notaVenta->peso_bruto = $totalPesoBruto;
			$notaVenta->volumen = $totalVolumen;

			$notaVenta->save();

			/*elimina detalles de nota de venta anteriores */
			$notaVenta->detalle()->delete();
			/* almacena detalles de nota venta */
			foreach ($detalleNV as $detalle) {

				NotaVentaDetalle::create($detalle);
			}

			$this->numero = $notaVenta->numero;

		}, 5);

		return $this->numero;
	}
}
