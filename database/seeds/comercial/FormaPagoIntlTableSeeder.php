<?php

use Illuminate\Database\Seeder;

class FormaPagoIntlTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formasPago = [
            ['descripcion' => 'Anticipo', 'activo' => 1],
            ['descripcion' => 'Cobranza 30 días', 'activo' => 1],
            ['descripcion' => '50% anticipo 50% a 60 días', 'activo' => 1],
            ['descripcion' => '30% anticipo 70% a 60 días', 'activo' => 1],
            ['descripcion' => '90 días fecha CRT', 'activo' => 1],
            ['descripcion' => '60 días fecha BL', 'activo' => 1],
            ['descripcion' => '75 días fecha BL', 'activo' => 1],
        ];
    }
}
