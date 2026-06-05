<?php

use App\Models\Membresia;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('calcula el precio de una membresia basic mensual', function () {
    expect(Membresia::precioPor('basic', 'mensual'))->toBe(299.0);
});

test('calcula el precio de una membresia premium trimestral', function () {
    expect(Membresia::precioPor('premium', 'trimestral'))->toBe(1299.0);
});

test('devuelve cero cuando la membresia no existe', function () {
    expect(Membresia::precioPor('gold', 'mensual'))->toBe(0.0);
});

test('una membresia activa dentro de fechas esta vigente', function () {
    Carbon::setTestNow('2026-06-04');

    $membresia = new Membresia([
        'fecha_inicio' => '2026-06-01',
        'fecha_fin' => '2026-06-30',
        'activa' => true,
    ]);

    expect($membresia->estaVigente())->toBeTrue();

    Carbon::setTestNow();
});

test('una membresia vencida no esta vigente', function () {
    Carbon::setTestNow('2026-06-04');

    $membresia = new Membresia([
        'fecha_inicio' => '2026-05-01',
        'fecha_fin' => '2026-05-31',
        'activa' => true,
    ]);

    expect($membresia->estaVigente())->toBeFalse();

    Carbon::setTestNow();
});

test('calcula los dias restantes de una membresia', function () {
    Carbon::setTestNow('2026-06-04');

    $membresia = new Membresia([
        'fecha_fin' => '2026-06-14',
    ]);

    expect($membresia->diasRestantes())->toBe(10);

    Carbon::setTestNow();
});