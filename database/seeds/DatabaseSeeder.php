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
        // $this->call(UsersTableSeeder::class);
        $this->call(TipoFamiliaTableSeeder::class);
        $this->call(FamiliaTableSeeder::class);
        $this->call(MarcasTableSeeder::class);
        $this->call(UnidadesTableSeeder::class);
        $this->call(SaboresTableSeeder::class);
        $this->call(NivelesTableSeeder::class);
    }
}
