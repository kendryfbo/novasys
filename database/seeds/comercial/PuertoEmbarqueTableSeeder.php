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
        [ 'nombre' => 'San Antonio', 'direccion' => 'Av. Barros Luco N°1613, of. 8 A San Antonio', 'tipo' => 'Maritimo', 'comuna' => 'San Antonio', 'ciudad' => 'San Antonio', 'fono' => '35-353340', 'activo' => 1],
        [ 'nombre' => 'Valparaiso', 'direccion' => 'Av. Errázuriz #25, Valparaiso', 'tipo' => 'Maritimo', 'comuna' => 'Valparaiso', 'ciudad' => 'Valparaiso', 'fono' => '32-2459500', 'activo' => 1],
        [ 'nombre' => 'Los Andes', 'direccion' => 'Los Andas', 'tipo' => 'Terrestre', 'comuna' => 'Los Andes', 'ciudad' => 'Los Andes', 'fono' => '34-370747', 'activo' => 1],
        [ 'nombre' => 'Arturo Merino Benítez', 'direccion' => 'Armando Cortinez Ote 1704, Pudahuel, Región Metropolitana', 'tipo' => 'Aereo', 'comuna' => 'Estacion Central', 'ciudad' => 'Santiago', 'fono' => '2-26901752', 'activo' => 1],
        [ 'nombre' => 'Santiago', 'direccion' => 'Santiago', 'tipo' => 'Terrestre', 'comuna' => 'Santiago', 'ciudad' => 'Santiago', 'fono' => '0-00', 'activo' => 1],
      ];

      foreach ($puertos as $puerto) {

        PuertoEmbarque::create($puerto);
      }
    }
}
