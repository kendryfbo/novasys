<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Zona;

class ZonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $zonas = [
        'descripcion' => 'America del Norte', 'activo' => 1,
        'descripcion' => 'America del Sur', 'activo' => 1,
        'descripcion' => 'Caribe', 'activo' => 1,
        'descripcion' => 'Centro America', 'activo' => 1,
      ];

      foreach ($zonas as $zona) {

        Zona::create($zona);
      }

    }
}
