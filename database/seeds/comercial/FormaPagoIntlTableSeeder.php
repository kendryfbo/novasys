<?php

use Illuminate\Database\Seeder;
use App\Models\Comercial\FormaPagoIntl;
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
            ['descripcion' => 'Anticipo', 'dias' => 1, 'activo' => 1],
            ['descripcion' => 'Cobranza 30 días', 'dias' => 30, 'activo' => 1],
            ['descripcion' => '50% anticipo 50% a 60 días', 'dias' => 60, 'activo' => 1],
            ['descripcion' => '30% anticipo 70% a 60 días', 'dias' => 70, 'activo' => 1],
            ['descripcion' => '90 días fecha CRT', 'dias' => 90, 'activo' => 1],
            ['descripcion' => '60 días fecha BL', 'dias' => 60, 'activo' => 1],
            ['descripcion' => '75 días fecha BL', 'dias' => 75, 'activo' => 1],
        ];

        foreach ($formasPago as $formas) {

            FormaPagoIntl::create($formas);
        }
    }
}
