<?php

namespace App\Repositories\Comercial\FacturaNacional;

use DB;
use App\Models\Comercial\Vendedor;
use App\Models\Comercial\Impuesto;
use App\Models\Comercial\NotaVenta;
use App\Models\Comercial\CentroVenta;
use App\Models\Comercial\ClienteNacional;
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
			$centroVenta = CentroVenta::find($request->centroVenta);
			$centroVentaID = $centroVenta->id;
			$centroVentaRut = $centroVenta->rut;
			$centroVenta = $centroVenta->descripcion;
			$cliente = ClienteNacional::find($request->cliente);
			$clienteID = $cliente->id;
			$clienteRut = $cliente->rut;
			$cliente = $cliente->descripcion;
			$condPago = $request->formaPago;
			$vendedor = Vendedor::find($request->vendedor);
			$direccion = $request->direccion;
			$despacho = $request->despacho;
			$observacion = $request->observacion;
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
				'vendedor_id' => $vendedor->id,
				'vendedor' => $vendedor->nombre,
				'direccion' => $direccion,
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
				'deuda' => $total,
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
				$codigo = $item->codigo;
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
					'codigo' => $codigo,
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

			$facturaNacional->neto = $totalNeto;
			$facturaNacional->descuento = $totalDescuento;
			$facturaNacional->iva = $totalIva;
			$facturaNacional->iaba = $totalIaba;
			$facturaNacional->sub_total = $totalSubTotal;
			$facturaNacional->total = $total;

			$facturaNacional->save();
		}, 5);
	}

	public function registerFromNV($request) {

		DB::transaction(function() use ($request) {

			$notaVenta = NotaVenta::with('detalles')->find($request->notaVenta);
			$centroVenta = CentroVenta::find($request->centroVenta);
			$cliente = ClienteNacional::find($request->cliente);
			$vendedor = Vendedor::find($request->vendedor);

			$numero = $request->numero;
			$notaVentaID = $notaVenta->id;
			$numeroNV = $notaVenta->numero;
			$subTotal = $notaVenta->sub_total;
			$descuento = $notaVenta->descuento;
			$neto = $notaVenta->neto;
			$iva = $notaVenta->iva;
			$iaba = $notaVenta->iaba;
			$total = $notaVenta->total;
			$pesoNeto = $notaVenta->peso_neto;
			$pesoBruto = $notaVenta->peso_bruto;
			$volumen = $notaVenta->volumen;
			$centroVentaId = $centroVenta->id;
			$centroVentaRut = $centroVenta->rut;
			$centroVenta = $centroVenta->descripcion;
			$clienteId = $cliente->id;
			$clienteRut = $cliente->rut;
			$cliente = $cliente->descripcion;
			$direccion = $notaVenta->direccion;
			$despacho = $notaVenta->despacho;
			$condPago = $notaVenta->cond_pago;
			$observacion = $request->observacion;
			$vendedorId = $vendedor->id;
			$vendedor = $vendedor->nombre;
			$user = $request->user()->id;
			$fechaEmision = $request->fechaEmision;
			$fechaVenc = $request->fechaVenc;

			$pagado = 0;

			$facturaNacional = FacturaNacional::create([
				'numero' => $numero,
				'numero_nv' => $numeroNV,
				'cv_id' => $centroVentaId,
				'cv_rut' => $centroVentaRut,
				'centro_venta' => $centroVenta,
				'cliente_id' => $clienteId,
				'cliente_rut' => $clienteRut,
				'cliente' => $cliente,
				'direccion' => $direccion,
				'despacho' => $despacho,
				'cond_pago' => $condPago,
				'observacion' => $observacion,
				'vendedor_id' => $vendedorId,
				'vendedor' => $vendedor,
				'sub_total' => $subTotal,
				'descuento' => $descuento,
				'neto' => $neto,
				'iva' => $iva,
				'iaba' => $iaba,
				'total' => $total,
				'deuda' => $total,
				'peso_neto' => $pesoNeto,
				'peso_bruto' => $pesoBruto,
				'volumen' => $volumen,
				'pagado' => $pagado,
				'user_id' => $user,
				'fecha_emision' => $fechaEmision,
				'fecha_venc' => $fechaVenc
			]);

			$factura = $facturaNacional->id;
			$items =  $notaVenta->detalle;
			$i = 0;

			foreach ($items as $item)
			{
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
				$subTotal = $item->sub_total;

				FacturaNacionalDetalle::create([
					'fact_id' => $factura,
					'item' => $i,
					'producto_id' => $id,
					'codigo' => $codigo,
					'descripcion' => $descripcion,
					'cantidad' => $cantidad,
					'precio' => $precio,
					'descuento' => $porcDesc,
					'sub_total' => $subTotal
				]);

			}

			$notaVenta->factura = $facturaNacional->numero;
			$notaVenta->save();

		}, 5);
	}

	public function delete($factura) {

		DB::transaction(function() use($factura) {

			if($factura->numero_nv) {

				$notaVenta = NotaVenta::where('numero', $factura->numero_nv)->first();

				$notaVenta->factura = null;
				$notaVenta->save();
			}

			$factura->delete();


		},5);
	}
}
