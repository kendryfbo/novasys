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
          'descripcion' => 'Español', 'activo' => 1,
          'descripcion' => 'Ingles', 'activo' => 1,
          'descripcion' => 'Portugués', 'activo' => 1,
        ]
    }
}
