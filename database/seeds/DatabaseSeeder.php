<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Semillas de Modulo Desarrollo
        $this->call(TipoFamiliaTableSeeder::class);
        $this->call(FamiliaTableSeeder::class);
        $this->call(MarcasTableSeeder::class);
        $this->call(FormatoTableSeeder::class);
        $this->call(UnidadesTableSeeder::class);
        $this->call(SaboresTableSeeder::class);
        $this->call(NivelesTableSeeder::class);

        // Semillas de Modulo Comercial
        $this->call(RegionesTableSeeder::class);
        $this->call(ProvinciasTableSeeder::class);
        $this->call(ComunasTableSeeder::class);

    }
}
