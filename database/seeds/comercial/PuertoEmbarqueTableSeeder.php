<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\PuertoEmbarque;

class PuertoEmbarqueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $puertos = [
        [ 'nombre' => 'San Antonio', 'direccion' => 'Av. Barros Luco N°1613, of. 8 A San Antonio', 'tipo' => 'Maritimo', 'activo' => 1],
        [ 'nombre' => 'Valparaiso', 'direccion' => 'Av. Errázuriz #25, Valparaiso', 'tipo' => 'Maritimo', 'activo' => 1],
        [ 'nombre' => 'Los Andes', 'direccion' => 'Los Andas', 'tipo' => 'Terrestre', 'activo' => 1],
        [ 'nombre' => 'Arturo Merino Benítez', 'direccion' => 'Armando Cortinez Ote 1704, Pudahuel, Región Metropolitana', 'tipo' => '', 'activo' => 1]
      ];

      foreach ($puertos as $puerto) {

        PuertoEmbarque::create($puerto);
      }
    }
}
