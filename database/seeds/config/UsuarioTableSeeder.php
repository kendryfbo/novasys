<?php

use App\Models\Config\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = [
            ['user' => 'kendryfbo', 'password' => Hash::make('19017070'), 'nombre' => 'Kendry', 'apellido' => 'Finol', 'email' => 'soporte@novafoods.cl', 'cargo' => 'Soporte', 'perfil_id' => 1, 'activo' => 1]
            ['user' => 'demo', 'password' => Hash::make('demo'), 'nombre' => 'Demo', 'apellido' => 'Demo', 'email' => 'soporte@novafoods.cl', 'cargo' => 'Demo', 'perfil_id' => 1, 'activo' => 1]
        ];

        foreach ($usuarios as $usuario) {

            Usuario::create($usuario);
        }
    }
}
