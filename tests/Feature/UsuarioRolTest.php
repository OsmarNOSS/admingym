<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('se puede crear un usuario con rol cliente', function () {
    $user = User::factory()->create([
        'rol' => 'cliente',
    ]);

    expect($user->rol)->toBe('cliente');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'rol' => 'cliente',
    ]);
});

test('se puede crear un usuario recepcionista', function () {
    $user = User::factory()->create([
        'rol' => 'recepcionista',
    ]);

    expect($user->rol)->toBe('recepcionista');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'rol' => 'recepcionista',
    ]);
});

