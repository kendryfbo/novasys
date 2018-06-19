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
            ['id' => 1, 'user' => 'kendryfbo', 'password' => Hash::make('19017070'), 'nombre' => 'Kendry', 'apellido' => 'Finol', 'email' => 'soporte@novafoods.cl', 'cargo' => 'Soporte', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 2, 'user' => 'demo', 'password' => Hash::make('demo'), 'nombre' => 'Demo', 'apellido' => 'Demo', 'email' => 'soporte@novafoods.cl', 'cargo' => 'Demo', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 3, 'user' => 'alexis', 'password' => Hash::make('af2017'), 'nombre' => 'Alexis', 'apellido' => 'Flores', 'email' => 'desarrollo@novafoods.cl', 'cargo' => 'Desarrollo', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 4, 'user' => 'alexandra', 'password' => Hash::make('ac2017'), 'nombre' => 'Alexandra', 'apellido' => 'Clark', 'email' => 'recepcion@novafoods.cl', 'cargo' => 'Recepcionista', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 5, 'user' => 'FINANZAS', 'password' => Hash::make('RANA'), 'nombre' => 'Viviana ', 'apellido' => 'Cabrera', 'email' => 'finanzas@novafoods.cl', 'cargo' => 'Finanzas', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 6, 'user' => 'CONTABILIDAD', 'password' => Hash::make('4713'), 'nombre' => 'Andres', 'apellido' => 'Alvarado', 'email' => 'contabilidad@novafoods.cl', 'cargo' => 'Gerente Administracion', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 7, 'user' => 'JEFEBODEGA', 'password' => Hash::make('JP17S'), 'nombre' => 'Andres', 'apellido' => 'Saldias', 'email' => 'bodega@novafoods.cl', 'cargo' => 'Jefe de Bodega', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 8, 'user' => 'OPERADOR', 'password' => Hash::make('1234'), 'nombre' => 'Johan', 'apellido' => 'x', 'email' => 'x', 'cargo' => 'x', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 9, 'user' => 'OPERSCAN', 'password' => Hash::make('2733'), 'nombre' => 'Scanner', 'apellido' => 'x', 'email' => 'x', 'cargo' => 'x', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 10, 'user' => 'COMEX', 'password' => Hash::make('2908'), 'nombre' => 'Victor', 'apellido' => 'Araya', 'email' => 'comex@novafoods.cl', 'cargo' => 'Comercio Exterior', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 11, 'user' => 'PLANIFICACION', 'password' => Hash::make('4825'), 'nombre' => 'Mabel', 'apellido' => 'Muñoz', 'email' => 'planificacion@novafoods.cl', 'cargo' => 'Jefe de Planificacion', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 12, 'user' => 'DESARROLLO', 'password' => Hash::make('MIX'), 'nombre' => 'Alexis', 'apellido' => 'Flores', 'email' => 'desarrollo@novafoods.cl', 'cargo' => 'Jefe de Desarrollo', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 13, 'user' => 'ACONTABLE', 'password' => Hash::make('1515'), 'nombre' => 'Karen', 'apellido' => 'Jorquera', 'email' => 'asistentecontable@novafoods.cl', 'cargo' => 'Asistente Contable', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 14, 'user' => 'ACALIDAD', 'password' => Hash::make('HACCP7'), 'nombre' => 'Veronica', 'apellido' => 'Pizarro', 'email' => 'aseguramientocalidad@novafoods.cl', 'cargo' => 'Aseguramiento de Calidad', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 15, 'user' => 'JCALIDAD', 'password' => Hash::make('102'), 'nombre' => 'Yader', 'apellido' => 'x', 'email' => 'calidad@novafoods.cl', 'cargo' => 'Jefe de Calidad', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 16, 'user' => 'MANTENCION', 'password' => Hash::make('MAN2007'), 'nombre' => 'Victor', 'apellido' => 'Rangel', 'email' => 'mantencion@novafoods.cl', 'cargo' => 'Jefe de Mantencion', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 17, 'user' => 'JEFEPLANTA', 'password' => Hash::make('2020'), 'nombre' => 'Francisco', 'apellido' => 'Badilla', 'email' => 'jefeplanta@novafoods.cl', 'cargo' => 'Jefe de Planta', 'perfil_id' => 1, 'activo' => 1],
            ['id' => 18, 'user' => 'RMANAGER', 'password' => Hash::make('2013'), 'nombre' => 'Javier', 'apellido' => 'Juanicotena', 'email' => 'regionalmanager@novafoods.cl', 'cargo' => 'Regional Manager', 'perfil_id' => 1, 'activo' => 1],
        ];

        foreach ($usuarios as $usuario) {

            Usuario::create($usuario);
        }
    }
}
