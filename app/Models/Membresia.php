<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Membresia extends Model
{
    use HasFactory;

    protected $table = 'membresias';

    protected $fillable = [
        'cliente_id',
        'sucursal_id',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'activa',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activa' => 'boolean',
    ];

    const PRECIOS = [
        'basic'   => ['mensual' => 299,  'trimestral' => 799,  'anual' => 2499],
        'premium' => ['mensual' => 499,  'trimestral' => 1299, 'anual' => 3999],
        'vip'     => ['mensual' => 799,  'trimestral' => 1999, 'anual' => 5999],
    ];

    public static function precioPor(string $tipo, string $periodo = 'mensual'): float
    {
        return self::PRECIOS[$tipo][$periodo] ?? 0;
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'membresia_id');
    }

    public function estaVigente(): bool
    {
        return $this->activa &&
            Carbon::now()->toDateString() >= $this->fecha_inicio->toDateString() &&
            Carbon::now()->toDateString() <= $this->fecha_fin->toDateString();
    }

    public function diasRestantes(): int
    {
        return (int) Carbon::now()->diffInDays($this->fecha_fin, false);
    }
}