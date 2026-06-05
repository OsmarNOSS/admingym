<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un usuario puede iniciar sesion correctamente', function () {

    $user = User::factory()->create([
        'email' => 'cliente@test.com',
        'password' => bcrypt('12345678'),
        'rol' => 'cliente',
    ]);

    $response = $this->post('/login', [
        'email' => 'cliente@test.com',
        'password' => '12345678',
    ]);

    $response->assertRedirect('/dashboard/cliente');    //porque es rol de cliente
    //$response->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('un usuario no puede iniciar sesion con contraseña incorrecta', function () {

    User::factory()->create([
        'email' => 'cliente@test.com',
        'password' => bcrypt('12345678'),
        'rol' => 'cliente',
    ]);

    $response = $this->post('/login', [
        'email' => 'cliente@test.com',
        'password' => 'incorrecta',
    ]);

    $this->assertGuest();
});