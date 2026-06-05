<?php

use App\Models\Cliente;
use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un cliente pertenece a un usuario', function () {
    $user = User::factory()->create([
        'rol' => 'cliente',
    ]);

    $cliente = Cliente::create([
        'user_id' => $user->id,
        'peso' => 70,
        'altura' => 1.75,
        'activo' => true,
    ]);

    expect($cliente->user->id)->toBe($user->id);
});

test('un cliente puede estar activo', function () {
    $cliente = new Cliente([
        'activo' => true,
    ]);

    expect($cliente->activo)->toBeTrue();
});

test('un cliente pertenece a una sucursal', function () {
    $sucursal = Sucursal::create([
        'nombre' => 'Sucursal Centro',
        'direccion' => 'Zitácuaro',
        'telefono' => '7151234567',
        'capacidad' => 80,
        'hora_apertura' => '06:00',
        'hora_cierre' => '22:00',
        'activa' => true,
    ]);

    $user = User::factory()->create([
        'rol' => 'cliente',
    ]);

    $cliente = Cliente::create([
        'user_id' => $user->id,
        'sucursal_id' => $sucursal->id,
        'peso' => 70,
        'altura' => 1.75,
        'activo' => true,
    ]);

    expect($cliente->sucursal->id)->toBe($sucursal->id);
});