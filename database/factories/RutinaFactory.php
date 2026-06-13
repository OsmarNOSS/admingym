<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class RutinaFactory extends Factory
{
    public function definition(): array
    {
        $nombres = [
            'Pérdida de peso', 'Ganancia muscular', 'Resistencia cardiovascular',
            'Flexibilidad y movilidad', 'Fuerza explosiva', 'Rehabilitación',
            'Tonificación', 'Alto rendimiento', 'Rutina funcional', 'Core y abdomen',
            'Lagartijas', 'Sentadillas', 'Burpees', 'Zancadas', 'Plancha'
        ];

        return [
            'nombre'       => FakerFactory::create()->randomElement($nombres) . ' ' . FakerFactory::create()->bothify('??##'),
            'descripcion'  => FakerFactory::create()->paragraph(3),
            'nivel'        => FakerFactory::create()->randomElement(['principiante', 'intermedio', 'avanzado']),
            'es_vip'       => FakerFactory::create()->boolean(20),
            'activa'       => true,
            'foto_portada' => null,
        ];
    }
}