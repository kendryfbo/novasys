<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon;
use App\Models\Producto;
use App\Models\Comercial\PlanOfertaDetalle;

class PlanOferta extends Model {

    protected $fillable = ['user_id', 'fecha_ingreso', 'descripcion', 'fecha_inicio','fecha_termino'];
    protected $table = 'plan_ofertas';

    static function register($request) {

        $planOferta = DB::transaction(function () use ($request) {

            $descripcion = $request->descripcion;
            $fechaInicio = $request->fecha_inicio;
            $fechaTermino = $request->fecha_termino;
            $fechaIngreso = Carbon\Carbon::now();
            $userID = $request->user()->id;
            $items = $request->items;

            $planOferta = PlanOferta::create([
              'fecha_ingreso' => $fechaIngreso,
              'fecha_inicio' => $fechaInicio,
              'fecha_termino' => $fechaTermino,
              'descripcion' => $descripcion,
              'user_id' => $userID,
            ]);

            foreach ($items as $item) {

              $item = json_decode($item);
                PlanOfertaDetalle::create([
                  'plan_id' => $planOferta->id,
                  'cliente_id' => $item->clientID,
                  'producto_id' => $item->id,
                  'nombre_cliente' => $item->cliente,
                  'nombre_producto' => $item->descripcion,
                  'descuento' => $item->descuento]);
            };
            return $planOferta;
        },5);
        return $planOferta;
    }

  static function registerEdit($request) {

      $planOferta = DB::transaction(function () use ($request) {

          $id = $request->id;
          $descripcion = $request->descripcion;
          $fechaTermino = $request->fecha_termino;
          $fechaInicio = $request->fecha_inicio;
          $userID = $request->user()->id;
          $items = $request->items;

          $planOferta = PlanOferta::find($id);
          $planOferta->descripcion = $descripcion;
          $planOferta->fecha_inicio = $fechaInicio;
          $planOferta->fecha_termino = $fechaTermino;
          $planOferta->user_id = $userID;
          $planOferta->detalles()->delete();
          $planOferta->update();

          foreach ($items as $item) {

            $item = json_decode($item);



              PlanOfertaDetalle::create([
                'plan_id' => $planOferta->id,
                'cliente_id' => $item->cliente_id,
                'producto_id' => $item->producto_id,
                'nombre_cliente' => $item->nombre_cliente,
                'nombre_producto' => $item->nombre_producto,
                'descuento' => $item->descuento]);

          };
          return $planOferta;
      },5);
      return $planOferta;
    }



    /*
    |
    |  Relationships
    |
    */

    public function detalles() {

        return $this->hasMany('App\Models\Comercial\PlanOfertaDetalle','plan_id');
    }

    public function Usuario() {

        return $this->belongsTo('App\Models\Config\Usuario','user_id');
    }
}
