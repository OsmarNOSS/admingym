<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
class SucursalFactory extends Factory
{
    public function definition(): array
    {
        $faker = FakerFactory::create();
        return [
            'nombre'        => 'AdminGym ' . $faker->city(),
            'direccion'     => $faker->address(),
            'telefono'      => $faker->numerify('715#######'),
            'capacidad'     => $faker->numberBetween(50, 300),
            'hora_apertura' => '06:00:00',
            'hora_cierre'   => '22:00:00',
            'activa'        => true,
            'foto_portada'  => null,
        ];
    }
}
