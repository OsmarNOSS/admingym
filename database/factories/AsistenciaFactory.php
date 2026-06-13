<?php
namespace Database\Factories;

use App\Models\Membresia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class AsistenciaFactory extends Factory
{
    public function definition(): array
    {
        $membresia = Membresia::where('activa', true)->inRandomOrder()->first();

        return [
            'cliente_id'        => $membresia->cliente_id,
            'sucursal_id'       => $membresia->sucursal_id,
            'registrado_por'    => User::whereIn('rol', ['recepcionista', 'admin_sucursal'])
                                       ->inRandomOrder()->first()->id,
            'membresia_id'      => $membresia->id,
            'fecha_entrada'     => FakerFactory::create()->dateTimeBetween('-6 months', 'now'),
            'acceso_permitido'  => FakerFactory::create()->boolean(90),
            'motivo_denegacion' => null,
        ];
    }
}