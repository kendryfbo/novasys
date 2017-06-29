<?php

use Illuminate\Database\Seeder;
use App\Models\Config\Acceso;

class AccesosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $accesos = [
        //Modulos Principales
        ['id' => 1, 'nombre' => 'desarrollo',    'descripcion' => 'Modulo Desarrollo',       'padre' => 'root', 'activo' => '1'],
        ['id' => 2, 'nombre' => 'comercial',     'descripcion' => 'Modulo Comercial',        'padre' => 'root', 'activo' => '1'],
        ['id' => 3, 'nombre' => 'finanzas',      'descripcion' => 'Modulo Finanzas',         'padre' => 'root', 'activo' => '1'],
        ['id' => 4, 'nombre' => 'operaciones',   'descripcion' => 'Modulo de Operaciones',   'padre' => 'root', 'activo' => '1'],
        ['id' => 5, 'nombre' => 'calidad',       'descripcion' => 'Modulo de Calidad',       'padre' => 'root', 'activo' => '1'],
        ['id' => 6, 'nombre' => 'informes',      'descripcion' => 'Modulo de Informes',      'padre' => 'root', 'activo' => '1'],
        ['id' => 7, 'nombre' => 'configuracion', 'descripcion' => 'Modulo de Configuracion', 'padre' => 'root', 'activo' => '1'],
        // Hijos de Modulo Desarrollo
        ['id' => 20, 'nombre' => 'desarrollo/productos',  'descripcion' => 'Productos',  'padre' => '1', 'activo' => '1'],
        ['id' => 21, 'nombre' => 'desarrollo/marcas',     'descripcion' => 'Marcas',     'padre' => '1', 'activo' => '1'],
        ['id' => 22, 'nombre' => 'desarrollo/familias',   'descripcion' => 'Familias',   'padre' => '1', 'activo' => '1'],
        ['id' => 23, 'nombre' => 'desarrollo/sabores',    'descripcion' => 'Sabores',    'padre' => '1', 'activo' => '1'],
        ['id' => 24, 'nombre' => 'desarrollo/formatos',   'descripcion' => 'Formatos',   'padre' => '1', 'activo' => '1'],
        ['id' => 25, 'nombre' => 'desarrollo/premezclas', 'descripcion' => 'Premezclas', 'padre' => '1', 'activo' => '1'],
        ['id' => 26, 'nombre' => 'desarrollo/insumos',    'descripcion' => 'Insumos',    'padre' => '1', 'activo' => '1'],
        ['id' => 27, 'nombre' => 'desarrollo/formulas',   'descripcion' => 'Formulas',   'padre' => '1', 'activo' => '1'],
        // ---
        // ['id' => 28, 'nombre' => '', 'descripcion' => '', 'padre' => '', 'activo' => '1'],
      ];

      foreach ($accesos as $acceso) {

        Acceso::create($acceso);
      }
    }
}
