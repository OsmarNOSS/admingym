<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Entrenador;
use App\Models\ClienteEntrenador;

class ClienteEntrenadorSeeder extends Seeder
{
    public function run(): void
    {
        $clienteUser = User::where('email', 'cliente@admingym.com')->first();
        $entrenadorUser = User::where('email', 'entrenador@admingym.com')->first();

        if (!$clienteUser || !$entrenadorUser) {
            return;
        }

        $cliente = Cliente::where('user_id', $clienteUser->id)->first();
        $entrenador = Entrenador::where('user_id', $entrenadorUser->id)->first();

        if (!$cliente || !$entrenador) {
            return;
        }

        ClienteEntrenador::updateOrCreate(
            [
                'cliente_id' => $cliente->id,
                'entrenador_id' => $entrenador->id,
            ],
            [
                'fecha_asignacion' => now()->toDateString(),
                'activo' => true,
            ]
        );
    }
}