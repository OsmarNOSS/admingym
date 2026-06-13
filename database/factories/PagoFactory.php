<?php
namespace Database\Factories;

use App\Models\Membresia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class PagoFactory extends Factory
{
    public function definition(): array
    {
        $montos    = ['basic' => 299, 'premium' => 499, 'vip' => 799];
        $membresia = Membresia::inRandomOrder()->first();

        return [
            'cliente_id'     => $membresia->cliente_id,
            'membresia_id'   => $membresia->id,
            'sucursal_id'    => $membresia->sucursal_id,
            'registrado_por' => User::whereIn('rol', ['recepcionista', 'admin_sucursal'])
                                    ->inRandomOrder()->first()->id,
            'monto'          => $montos[$membresia->tipo],
            'metodo_pago'    => FakerFactory::create()->randomElement(['efectivo', 'tarjeta', 'transferencia']),
            'fecha_pago'     => FakerFactory::create()->dateTimeBetween('-1 year', 'now'),
            'concepto'       => 'Pago membresía ' . ucfirst($membresia->tipo),
        ];
    }
}