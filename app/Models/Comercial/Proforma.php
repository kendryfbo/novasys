<?php

namespace App\Models\Comercial;

use DB;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\FormaPagoIntl;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $fillable = [
        'numero', 'version', 'cv_id', 'centro_venta', 'cliente_id', 'cliente', 'fecha_emision',
        'semana', 'direccion', 'nota', 'transporte', 'puerto_emb', 'puerto_dest', 'forma_pago',
        'clau_venta', 'peso_neto', 'peso_bruto', 'volumen', 'fob', 'freight', 'insurance',
        'cif', 'descuento','total','user_id'
    ];

    public function detalles() {

        return $this->hasMany(ProformaDetalle::class);
    }

    public function guiaDespacho() {

        return $this->hasOne(GuiaDespacho::class);
    }

    static function register($request) {

        DB::transaction(function () use ($request) {

    		$totalDescuento = 0;
    		$totalFob = 0;
            $totalCif = 0;
    		$total = 0;
    		$totalPesoNeto = 0;
    		$totalPesoBruto = 0;
    		$totalVolumen = 0;

    		$numero = Proforma::orderBy('numero','desc')->pluck('numero')->first();

            if (is_null($numero)) {

    			$numero = 1;

    		} else {

    			$numero++;
    		};

            $version = 1;


            $cvId = $request->centroVenta;
            $cvDescrip = CentroVenta::find($cvId)->pluck('descripcion')->first();

    		$clienteId = $request->cliente;
    		$clienteDescrip = ClienteIntl::where('id','=',$clienteId)->select('descripcion')->first()->descripcion;

            $fechaEmision = $request->emision;
            $semana = $request->semana;
            $direccion = $request->direccion;
            $nota = $request->nota;
            $transporte = $request->transporte;
            $puertoE = $request->puertoE;
            $puertoD = $request->puertoD;
    		$formaPago = $request->formaPago;
            $clausula = $request->clausula;
    		$user = $request->user()->id;

            $freight = $request->freight;
            $insurance = $request->insurance;

    		$proforma = Proforma::create([
    			'numero' => $numero,
                'version' => $version,
    			'cv_id' => $cvId,
    			'centro_venta' => $cvDescrip,
    			'cliente_id' => $clienteId,
    			'cliente' => $clienteDescrip,
                'fecha_emision' => $fechaEmision,
                'semana' => $semana,
    			'direccion' => $direccion,
                'nota' => $nota,
    			'transporte' => $transporte,
                'puerto_emb' => $puertoE,
                'puerto_dest' => $puertoD,
                'forma_pago' => $formaPago,
    			'clau_venta' => $clausula,
                'peso_neto' => $totalPesoNeto,
                'peso_bruto' => $totalPesoBruto,
                'volumen' => $totalVolumen,
                'fob' => $totalFob,
                'freight' => $freight,
                'insurance' => $insurance,
                'cif' => $totalCif,
    			'descuento' => $totalDescuento,
                'total' => $total,
                'user_id' => $user
    		]);

    		$proformaId = $proforma->id;
    		$items =  $request->items;
    		$detalles = [];
    		$i = 0;

    		foreach ($items as $item) {

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
    			$pesoNeto = $item->peso_neto;
    			$pesoBruto = $item->peso_bruto;
    			$volumen = $item->volumen;

    			$subTotal = $cantidad * $precio;
    			$descuento = ($subTotal * $porcDesc) / 100;

    			$detalles[] = [
    				'proforma_id' => $proformaId,
    				'item' => $i,
    				'producto_id' => $id,
    				'codigo' => $codigo,
    				'descripcion' => $descripcion,
    				'cantidad' => $cantidad,
    				'precio' => $precio,
    				'descuento' => $porcDesc,
    				'sub_total' => $subTotal,
                    'peso_neto' => $pesoNeto,
                    'peso_bruto' => $pesoBruto,
                    'volumen' => $volumen
    			];

    			$totalFob += $subTotal;
    			$totalDescuento += $descuento;
    			$totalPesoNeto += $pesoNeto;
    			$totalPesoBruto += $pesoBruto;
    			$totalVolumen += $volumen;

    		};

    		foreach ($detalles as $detalle) {

    			ProformaDetalle::create($detalle);
    		}

            $total = $totalFob + $freight + $insurance;

    		$proforma->descuento = $totalDescuento;
            $proforma->fob = $totalFob;
    		$proforma->total = $total;
    		$proforma->peso_neto = $totalPesoNeto;
    		$proforma->peso_bruto = $totalPesoBruto;
    		$proforma->volumen = $totalVolumen;

    		$proforma->save();

    	}, 5);

    	return Proforma::orderBy('numero','desc')->pluck('numero')->first();
      }

      static function edit($request,$proforma) {

          DB::transaction(function () use ($request,$proforma) {

      		$totalDescuento = 0;
      		$totalFob = 0;
            $totalCif = 0;
      		$total = 0;
      		$totalPesoNeto = 0;
      		$totalPesoBruto = 0;
      		$totalVolumen = 0;

            $proforma = Proforma::where('numero',$proforma)->first();

            $version = $proforma->version + 1;


            $cvId = $request->centroVenta;
            $cvDescrip = CentroVenta::find($cvId)->pluck('descripcion')->first();

      		$clienteId = $request->cliente;
      		$clienteDescrip = ClienteIntl::where('id','=',$clienteId)->select('descripcion')->first()->descripcion;

            $fechaEmision = $request->emision;
            $semana = $request->semana;
            $direccion = $request->direccion;
            $nota = $request->nota;
            $transporte = $request->transporte;
            $puertoE = $request->puertoE;
            $puertoD = $request->puertoD;
            $formaPago = $request->formaPago;
            $clausula = $request->clausula;
            $user = $request->user()->id;

            $freight = $request->freight;
            $insurance = $request->insurance;

            $proforma->version = $version;
            $proforma->cv_id = $cvId;
            $proforma->centro_venta = $cvDescrip;
            $proforma->cliente_id = $clienteId;
            $proforma->cliente = $clienteDescrip;
            $proforma->fecha_emision = $fechaEmision;
            $proforma->semana = $semana;
            $proforma->direccion = $direccion;
            $proforma->nota = $nota;
            $proforma->transporte = $transporte;
            $proforma->puerto_emb = $puertoE;
            $proforma->puerto_dest = $puertoD;
            $proforma->forma_pago = $formaPago;
            $proforma->clau_venta = $clausula;
            $proforma->peso_neto = $totalPesoNeto;
            $proforma->peso_bruto = $totalPesoBruto;
            $proforma->volumen = $totalVolumen;
            $proforma->fob = $totalFob;
            $proforma->freight = $freight;
            $proforma->insurance = $insurance;
            $proforma->cif = $totalCif;
            $proforma->descuento = $totalDescuento;
            $proforma->total = $total;
            $proforma->user_id = $user;

            $proforma->save();

            $proformaId = $proforma->id;
      		$items =  $request->items;
      		$detalles = [];
      		$i = 0;

      		foreach ($items as $item) {

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
      			$pesoNeto = $item->peso_neto;
      			$pesoBruto = $item->peso_bruto;
      			$volumen = $item->volumen;

      			$subTotal = $cantidad * $precio;
      			$descuento = ($subTotal * $porcDesc) / 100;

      			$detalles[] = [
      				'proforma_id' => $proformaId,
      				'item' => $i,
      				'producto_id' => $id,
      				'codigo' => $codigo,
      				'descripcion' => $descripcion,
      				'cantidad' => $cantidad,
      				'precio' => $precio,
      				'descuento' => $porcDesc,
      				'sub_total' => $subTotal,
                      'peso_neto' => $pesoNeto,
                      'peso_bruto' => $pesoBruto,
                      'volumen' => $volumen
      			];

      			$totalFob += $subTotal;
      			$totalDescuento += $descuento;
      			$totalPesoNeto += $pesoNeto;
      			$totalPesoBruto += $pesoBruto;
      			$totalVolumen += $volumen;

      		};

            ProformaDetalle::where('proforma_id', $proformaId)->delete();

      		foreach ($detalles as $detalle) {

      			ProformaDetalle::create($detalle);
      		}

            $total = $totalFob + $freight + $insurance;

            $proforma->descuento = $totalDescuento;
            $proforma->fob = $totalFob;
            $proforma->total = $total;
            $proforma->peso_neto = $totalPesoNeto;
            $proforma->peso_bruto = $totalPesoBruto;
            $proforma->volumen = $totalVolumen;

            $proforma->save();

      	}, 5);

      	return Proforma::orderBy('numero','desc')->pluck('numero')->first();
    }

    static function getAllUnathorized() {

        return self::whereNull('aut_comer')->get();
    }

    public function authorize() {

        $this->aut_comer = 1;
        $this->aut_contab = 1; // Temporal hasta implementacion de Modulo de Finanzas

        $this->save();

    }

    public function unauthorize() {

        $this->aut_comer = 0;
        $this->aut_contab = 0; // Temporal hasta implementacion de Modulo de Finanzas

        $this->save();
    }
}
