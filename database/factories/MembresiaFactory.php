<?php
namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Sucursal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class MembresiaFactory extends Factory
{
    public function definition(): array
    {
        $inicio = Carbon::now()->subDays(FakerFactory::create()->numberBetween(0, 365));
        $dias   = FakerFactory::create()->randomElement([30, 60, 90, 180, 365]);
        $fin    = $inicio->copy()->addDays($dias);

        return [
            'cliente_id'   => Cliente::inRandomOrder()->first()->id,
            'sucursal_id'  => Sucursal::inRandomOrder()->first()->id,
            'tipo'         => FakerFactory::create()->randomElement(['basic', 'premium', 'vip']),
            'fecha_inicio' => $inicio->format('Y-m-d'),
            'fecha_fin'    => $fin->format('Y-m-d'),
            'activa'       => $fin->isFuture(),
        ];
    }
}