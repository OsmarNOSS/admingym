<?php

use App\Models\Pago;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\Sucursal;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function crearDatosParaPago()
{
    $sucursal = Sucursal::create([
        'nombre' => 'Sucursal Centro',
        'direccion' => 'Zitácuaro',
        'telefono' => '7151234567',
        'capacidad' => 80,
        'hora_apertura' => '06:00',
        'hora_cierre' => '22:00',
        'activa' => true,
    ]);

    $userCliente = User::factory()->create([
        'rol' => 'cliente',
    ]);

    $cliente = Cliente::create([
        'user_id' => $userCliente->id,
        'sucursal_id' => $sucursal->id,
        'activo' => true,
    ]);

    $membresia = Membresia::create([
        'cliente_id' => $cliente->id,
        'sucursal_id' => $sucursal->id,
        'tipo' => 'basic',
        'fecha_inicio' => now(),
        'fecha_fin' => now()->addMonth(),
        'activa' => true,
    ]);

    $registrador = User::factory()->create([
        'rol' => 'recepcionista',
    ]);

    return [$cliente, $membresia, $sucursal, $registrador];
}

test('un pago pertenece a un cliente', function () {
    [$cliente, $membresia, $sucursal, $registrador] = crearDatosParaPago();

    $pago = Pago::create([
        'cliente_id' => $cliente->id,
        'membresia_id' => $membresia->id,
        'sucursal_id' => $sucursal->id,
        'registrado_por' => $registrador->id,
        'monto' => 500,
        'metodo_pago' => 'efectivo',
        'fecha_pago' => now(),
    ]);

    expect($pago->cliente->id)->toBe($cliente->id);
});

test('un pago pertenece a una membresia', function () {
    [$cliente, $membresia, $sucursal, $registrador] = crearDatosParaPago();

    $pago = Pago::create([
        'cliente_id' => $cliente->id,
        'membresia_id' => $membresia->id,
        'sucursal_id' => $sucursal->id,
        'registrado_por' => $registrador->id,
        'monto' => 500,
        'metodo_pago' => 'efectivo',
        'fecha_pago' => now(),
    ]);

    expect($pago->membresia->id)->toBe($membresia->id);
});

test('un pago pertenece a una sucursal', function () {
    [$cliente, $membresia, $sucursal, $registrador] = crearDatosParaPago();

    $pago = Pago::create([
        'cliente_id' => $cliente->id,
        'membresia_id' => $membresia->id,
        'sucursal_id' => $sucursal->id,
        'registrado_por' => $registrador->id,
        'monto' => 500,
        'metodo_pago' => 'efectivo',
        'fecha_pago' => now(),
    ]);

    expect($pago->sucursal->id)->toBe($sucursal->id);
});

test('un pago fue registrado por un usuario', function () {
    [$cliente, $membresia, $sucursal, $registrador] = crearDatosParaPago();

    $pago = Pago::create([
        'cliente_id' => $cliente->id,
        'membresia_id' => $membresia->id,
        'sucursal_id' => $sucursal->id,
        'registrado_por' => $registrador->id,
        'monto' => 500,
        'metodo_pago' => 'efectivo',
        'fecha_pago' => now(),
    ]);

    expect($pago->registrado_por)->toBe($registrador->id);
});