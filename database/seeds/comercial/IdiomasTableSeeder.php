<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\Idioma;

class IdiomasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idiomas = [
            ['descripcion' => 'Portugués', 'activo' => 1],
            ['descripcion' => 'Español', 'activo' => 1],
            ['descripcion' => 'Ingles', 'activo' => 1],
      ];

      foreach ($idiomas as $idioma) {

          Idioma::create($idioma);
      }

    }
}
