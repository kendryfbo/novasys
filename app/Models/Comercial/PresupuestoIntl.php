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


            $items = [
                [   'month' => $request->mes1,
                    'amount' => $request->enero],
                [   'month' => $request->mes2,
                    'amount' => $request->febrero],
                [   'month' => $request->mes3,
                    'amount' => $request->marzo],
                [   'month' => $request->mes4,
                    'amount' => $request->abril],
                [   'month' => $request->mes5,
                    'amount' => $request->mayo],
                [   'month' => $request->mes6,
                    'amount' => $request->junio],
                [   'month' => $request->mes7,
                    'amount' => $request->julio],
                [   'month' => $request->mes8,
                    'amount' => $request->agosto],
                [   'month' => $request->mes9,
                    'amount' => $request->septiembre],
                [   'month' => $request->mes10,
                    'amount' => $request->octubre],
                [   'month' => $request->mes11,
                    'amount' => $request->noviembre],
                [   'month' => $request->mes12,
                    'amount' => $request->diciembre]
            ];



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

              PresupuestoIntlDetalle::create([
              'presupuesto_id' => $presupuestoIntl->id,
              'month' => $item['month'],
              'amount' => $item['amount']]);
            };
            return $presupuestoIntl;
        },5);
        return $presupuestoIntl;
    }

    static function registerEdit($request, $presupuestoIntl) {

        $presupuestoIntl = DB::transaction(function () use ($request, $presupuestoIntl) {

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

        static function unauthorized() {

          return self::whereNull('auth_presupuesto')->get();

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
