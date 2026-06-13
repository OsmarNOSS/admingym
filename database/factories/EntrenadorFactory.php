<?php
namespace Database\Factories;

use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class EntrenadorFactory extends Factory
{
    public function definition(): array
    {
        $especialidades = [
            'Funcional', 'Spinning', 'Nutrición',
            'Crossfit', 'Yoga', 'Musculación', 'Cardio', 'Pesas', 'Resistencia'
        ];

        return [
            'sucursal_id'  => Sucursal::inRandomOrder()->first()->id,
            'telefono'     => FakerFactory::create()->numerify('715#######'),
            'especialidad' => FakerFactory::create()->randomElement($especialidades),
            'activo'       => true,
            'foto_perfil'  => null,
        ];
    }
}