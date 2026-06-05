<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Sucursal;
use App\Models\Cliente;
use App\Models\Entrenador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $sucursal = Sucursal::firstOrCreate(
            ['nombre' => 'Sucursal Centro'],
            [
                'direccion' => 'Zitácuaro, Michoacán',
                'telefono' => '7151234567',
                'capacidad' => 80,
                'hora_apertura' => '06:00',
                'hora_cierre' => '22:00',
                'activa' => true,
            ]
        );

        /*
        $superAdmin = User::firstOrCreate(
            ['email' => 'super@admingym.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
                'rol' => 'super_admin',
                'sucursal_id' => null,
            ]
        );
        $superAdmin->syncRoles(['super_admin']);
*/
        $admin = User::firstOrCreate(
            ['email' => 'admin@admingym.com'],
            [
                'name' => 'Admin Sucursal',
                'password' => Hash::make('12345678'),
                'rol' => 'admin_sucursal',
                'sucursal_id' => $sucursal->id,
            ]
        );
        $admin->syncRoles(['admin_sucursal']);

        $recepcionista = User::firstOrCreate(
            ['email' => 'recepcion@admingym.com'],
            [
                'name' => 'Recepcionista',
                'password' => Hash::make('12345678'),
                'rol' => 'recepcionista',
                'sucursal_id' => $sucursal->id,
            ]
        );
        $recepcionista->syncRoles(['recepcionista']);

        $entrenadorUser = User::firstOrCreate(
            ['email' => 'entrenador@admingym.com'],
            [
                'name' => 'Entrenador',
                'password' => Hash::make('12345678'),
                'rol' => 'entrenador',
                'sucursal_id' => $sucursal->id,
            ]
        );
        $entrenadorUser->syncRoles(['entrenador']);
Entrenador::firstOrCreate(
    ['user_id' => $entrenadorUser->id],
    [
        'sucursal_id' => $sucursal->id,
        'telefono' => '7150000000',
        'especialidad' => 'Funcional',
        'activo' => true,
    ]
);

        $clienteUser = User::firstOrCreate(
            ['email' => 'cliente@admingym.com'],
            [
                'name' => 'Cliente',
                'password' => Hash::make('12345678'),
                'rol' => 'cliente',
                'sucursal_id' => $sucursal->id,
            ]
        );
        $clienteUser->syncRoles(['cliente']);

        Cliente::firstOrCreate(
            ['user_id' => $clienteUser->id],
            [
                'sucursal_id' => $sucursal->id,
                'peso' => 70,
                'altura' => 1.70,
                'fecha_nacimiento' => '2000-01-01',
                'activo' => true,
            ]
        );
    }
}