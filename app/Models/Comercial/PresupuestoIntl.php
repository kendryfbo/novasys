<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon;
use App\Models\Comercial\PresupuestoIntlDetalle;

class PresupuestoIntl extends Model {

    protected $fillable = ['user_id', 'year', 'fecha_ingreso', 'auth_presupuesto', 'version'];
    protected $table = 'presupuesto_intl';

    static function register($request) {

        $presupuestoIntl = DB::transaction(function () use ($request) {

            $userID = $request->user()->id;
            $fechaIngreso = Carbon\Carbon::now();
            $year = $request->year;
            $items = $request->items;

            $lastVersion = DB::table('presupuesto_intl')
                ->where('year',$year)
                ->orderBy('version', 'desc')
                ->first();

            if (empty($lastVersion->version)) {
                $lastVersion = 0;
            } else {
              $lastVersion = $lastVersion->version;
            }



            $presupuestoIntl = PresupuestoIntl::create([
              'user_id' => $userID,
              'year' => $year,
              'fecha_ingreso' => $fechaIngreso,
              'auth_presupuesto' => '0',
              'version' => $lastVersion + 1,
            ]);
              foreach ($items as $item) {
                $item = json_decode($item);

              PresupuestoIntlDetalle::create([
              'presupuesto_id' => $presupuestoIntl->id,
              'month' => $item->mesID,
              'amount' => $item->monto]);
            };
            return $presupuestoIntl;
        },5);
        return $presupuestoIntl;
    }

    static function registerEdit($request) {

        $presupuestoIntl = DB::transaction(function () use ($request) {

          $id = $request->id;
          $descripcion = $request->descripcion;
          $fechaTermino = $request->fecha_termino;
          $fechaInicio = $request->fecha_inicio;
          $userID = $request->user()->id;
          $items = $request->items;

          $presupuestoIntl = PresupuestoIntl::find($id);
          $presupuestoIntl->year;
          $presupuestoIntl->detalles()->delete();
          $presupuestoIntl->update();

          foreach ($items as $item) {

            $item = json_decode($item);

              PresupuestoIntlDetalle::create([
                'presupuesto_id' => $presupuestoIntl->id,
                'month' => $item->month,
                'amount' => $item->amount]);

            };
            return $presupuestoIntl;
        },5);
        return $presupuestoIntl;
    }


    /*
    |
    |  Relationships
    |
    */

    public function meses() {

        return $this->belongsTo('App\Models\Mes','month');
    }

    public function detalles() {

        return $this->hasMany('App\Models\Comercial\PresupuestoIntlDetalle','presupuesto_id');
    }

    public function Usuario() {

        return $this->belongsTo('App\Models\Config\Usuario','user_id');
    }
}
