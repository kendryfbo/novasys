<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Bodega\Posicion;
use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{

    protected $fillable = ['descripcion', 'bloque', 'columna', 'estante', 'activo'];


    /*
     *    STATIC FUNCTIONS
     */

     static function getAllActive() {

        return self::all()->where('activo',1);
     }

     static function getPositions($bodegaId) {

         $bloques = Posicion::where('bodega_id',$bodegaId)->orderBy('bloque','asc')->groupBy('bloque')->pluck('bloque');

         foreach ($bloques as $keyBloq => $bloque) {

             $estantes = Posicion::where('bodega_id',$bodegaId)->where('bloque',$bloque)->orderBy('estante','desc')->groupBy('estante')->pluck('estante');

             foreach ($estantes as $keyEstante => $estante) {

                 $posicion = Posicion::with('status')->orderBy('columna','asc')->where('bodega_id',$bodegaId)->where('bloque',$bloque)->where('estante',$estante)->get();

                 $estantes[$keyEstante] = $posicion;
             }
             $bloques[$keyBloq] = $estantes;
         };

         return $bloques;
     }

    static function createBodega($request) {

        DB::transaction(function () use ($request) {

            $bodega = Bodega::create([
                'descripcion' => $request->descripcion,
                'activo' => $request->activo
            ]);


            $bloques = $request->bloque;
            $columnas = $request->columna;
            $estantes = $request->estante;


            for ($bloque=0; $bloque < $bloques; $bloque++) {

                for ($columna=0; $columna < $columnas; $columna++) {

                    for ($estante=0; $estante < $estantes; $estante++) {

                        Posicion::create([
                            'bodega_id' => $bodega->id,
                            'bloque' => $bloque+1,
                            'columna' => $columna+1,
                            'estante' => $estante+1,
                            'medida' => 'TEST',
                            'status_id' => 2
                        ]);
                    }
                }
            }

        },5); // transaction
    }
}
