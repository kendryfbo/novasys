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
            ['id' => 1, 'descripcion' => 'Anticipo', 'dias' => 1, 'activo' => 1],
            ['id' => 2, 'descripcion' => 'Cobranza 30 días', 'dias' => 30, 'activo' => 1],
            ['id' => 3, 'descripcion' => '50% anticipo 50% a 60 días', 'dias' => 60, 'activo' => 1],
            ['id' => 4, 'descripcion' => '30% anticipo 70% a 60 días', 'dias' => 60, 'activo' => 1],
            ['id' => 5, 'descripcion' => '90 días fecha CRT', 'dias' => 90, 'activo' => 1],
            ['id' => 6, 'descripcion' => '60 días fecha BL', 'dias' => 60, 'activo' => 1],
            ['id' => 7, 'descripcion' => '75 días fecha BL', 'dias' => 75, 'activo' => 1],
            ['id' => 8, 'descripcion' => '60 días fecha CRT', 'dias' => 60, 'activo' => 1],
        ];

        foreach ($formasPago as $formas) {

            FormaPagoIntl::create($formas);
        }
    }
}
