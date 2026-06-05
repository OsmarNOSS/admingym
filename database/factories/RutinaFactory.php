<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'nombre'       => fake()->randomElement($nombres) . ' ' . fake()->bothify('??##'),
            'descripcion'  => fake()->paragraph(3),
            'nivel'        => fake()->randomElement(['principiante', 'intermedio', 'avanzado']),
            'es_vip'       => fake()->boolean(20),
            'activa'       => true,
            'foto_portada' => null,
        ];
    }
}