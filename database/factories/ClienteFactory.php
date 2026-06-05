<?php
namespace Database\Factories;

use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sucursal_id'      => Sucursal::inRandomOrder()->first()->id,
            'peso'             => fake()->randomFloat(2, 50, 120),
            'altura'           => fake()->randomFloat(2, 1.50, 2.00),
            'fecha_nacimiento' => fake()->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'activo'           => true,
            'foto_perfil'      => null,
        ];
    }
}