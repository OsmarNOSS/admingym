<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SucursalFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre'        => 'AdminGym ' . fake()->city(),
            'direccion'     => fake()->address(),
            'telefono'      => fake()->numerify('715#######'),
            'capacidad'     => fake()->numberBetween(50, 300),
            'hora_apertura' => '06:00:00',
            'hora_cierre'   => '22:00:00',
            'activa'        => true,
            'foto_portada'  => null,
        ];
    }
}