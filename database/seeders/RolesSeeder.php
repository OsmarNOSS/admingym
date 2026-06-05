<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'super_admin',
            'admin_sucursal',
            'recepcionista',
            'entrenador',
            'cliente',
        ];

        foreach ($roles as $rol) {
            Role::firstOrCreate([
                'name' => $rol,
                'guard_name' => 'web',
            ]);
        }
    }
}