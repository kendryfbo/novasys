<?php

use Illuminate\Database\Seeder;
use App\Models\Formato;
class FormatoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formatos = [];

        foreach ($formatos as $formato) {

            Formato::create($formato);
        }

    }
}
