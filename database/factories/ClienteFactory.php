<?php
namespace Database\Factories;

use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sucursal_id'      => Sucursal::inRandomOrder()->first()->id,
            'peso'             => FakerFactory::create()->randomFloat(2, 50, 120),
            'altura'           => FakerFactory::create()->randomFloat(2, 1.50, 2.00),
            'fecha_nacimiento' => FakerFactory::create()->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'activo'           => true,
            'foto_perfil'      => null,
        ];
    }
}