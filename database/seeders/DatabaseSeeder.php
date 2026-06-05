<?php
namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteEntrenador;
use App\Models\ClienteRutina;
use App\Models\Entrenador;
use App\Models\Membresia;
use App\Models\Rutina;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Resetear caché de roles de Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Roles de Spatie (deben existir antes que los usuarios)
        $roles = ['super_admin', 'admin_sucursal', 'recepcionista', 'entrenador', 'cliente'];
        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol, 'guard_name' => 'web']);
        }

        // 2. Sucursales
        Sucursal::factory(5)->create();

        // 3. Super Admin
        $superAdmin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'super@admingym.com',
            'password' => Hash::make('password'),
            'rol'      => 'super_admin',
        ]);
        $superAdmin->assignRole('super_admin');

        // 4. Admins y recepcionistas por sucursal
        Sucursal::all()->each(function ($sucursal) {
            $admin = User::factory()->create([
                'rol'         => 'admin_sucursal',
                'sucursal_id' => $sucursal->id,
            ]);
            $admin->assignRole('admin_sucursal');

            User::factory(2)->create([
                'rol'         => 'recepcionista',
                'sucursal_id' => $sucursal->id,
            ])->each(fn($u) => $u->assignRole('recepcionista'));
        });

        // 5. Rutinas
        Rutina::factory(30)->create();

        // 6. Entrenadores (50)
        for ($i = 0; $i < 50; $i++) {
            $sucursal = Sucursal::inRandomOrder()->first();
            $user = User::factory()->create([
                'rol'         => 'entrenador',
                'sucursal_id' => $sucursal->id,
            ]);
            $user->assignRole('entrenador');
            Entrenador::factory()->create([
                'user_id'     => $user->id,
                'sucursal_id' => $sucursal->id,
            ]);
        }

        // 7. Clientes (500)
        for ($i = 0; $i < 500; $i++) {
            $sucursal = Sucursal::inRandomOrder()->first();
            $user = User::factory()->create([
                'rol'         => 'cliente',
                'sucursal_id' => $sucursal->id,
            ]);
            $user->assignRole('cliente');
            Cliente::factory()->create([
                'user_id'     => $user->id,
                'sucursal_id' => $sucursal->id,
            ]);
        }

        // 8. Membresías (2 por cliente)
        Cliente::all()->each(function ($cliente) {
            Membresia::factory(2)->create([
                'cliente_id'  => $cliente->id,
                'sucursal_id' => $cliente->sucursal_id ?? Sucursal::inRandomOrder()->first()->id,
            ]);
        });

        // 9. Pagos
        Membresia::all()->each(function ($membresia) {
            \App\Models\Pago::factory()->create([
                'cliente_id'   => $membresia->cliente_id,
                'membresia_id' => $membresia->id,
                'sucursal_id'  => $membresia->sucursal_id,
            ]);
        });

        // 10. Asignación cliente-entrenador (N:M)
        Cliente::all()->each(function ($cliente) {
            $entrenadores = Entrenador::inRandomOrder()->take(rand(1, 2))->get();
            foreach ($entrenadores as $entrenador) {
                ClienteEntrenador::firstOrCreate(
                    ['cliente_id' => $cliente->id, 'entrenador_id' => $entrenador->id],
                    ['fecha_asignacion' => now()->format('Y-m-d'), 'activo' => true]
                );
            }
        });

        // 11. Asignación cliente-rutina (N:M)
        Cliente::all()->each(function ($cliente) {
            $rutinas = Rutina::inRandomOrder()->take(rand(1, 3))->get();
            foreach ($rutinas as $rutina) {
                $entrenador = Entrenador::inRandomOrder()->first();
                ClienteRutina::firstOrCreate(
                    ['cliente_id' => $cliente->id, 'rutina_id' => $rutina->id],
                    [
                        'entrenador_id'    => $entrenador->id,
                        'fecha_asignacion' => now()->format('Y-m-d'),
                        'activa'           => true,
                    ]
                );
            }
        });

        // 12. Asistencias
        Membresia::where('activa', true)->inRandomOrder()->take(400)->get()
            ->each(function ($membresia) {
                \App\Models\Asistencia::factory(2)->create([
                    'cliente_id'   => $membresia->cliente_id,
                    'sucursal_id'  => $membresia->sucursal_id,
                    'membresia_id' => $membresia->id,
                ]);
            });
    }
}