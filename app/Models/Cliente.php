<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'user_id',
        'sucursal_id',
        'peso',
        'altura',
        'fecha_nacimiento',
        'activo',
        'foto_perfil',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function membresias()
    {
        return $this->hasMany(Membresia::class, 'cliente_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'cliente_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'cliente_id');
    }

    public function entrenadores()
    {
        return $this->belongsToMany(Entrenador::class, 'cliente_entrenador')
            ->withPivot('fecha_asignacion', 'activo')
            ->withTimestamps();
    }

    public function asignacionesEntrenador()
    {
        return $this->hasMany(ClienteEntrenador::class, 'cliente_id');
    }

    public function rutinas()
    {
        return $this->belongsToMany(Rutina::class, 'cliente_rutina')
            ->withPivot('entrenador_id', 'fecha_asignacion', 'activa')
            ->withTimestamps();
    }
}