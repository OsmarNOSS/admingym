<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    use HasFactory;

    protected $table = 'rutinas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'nivel',
        'es_vip',
        'activa',
        'foto_portada',
    ];

    protected $casts = [
        'es_vip' => 'boolean',
        'activa' => 'boolean',
    ];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_rutina')
            ->withPivot('entrenador_id', 'fecha_asignacion', 'activa')
            ->withTimestamps();
    }

    public function asignaciones()
    {
        return $this->hasMany(ClienteRutina::class, 'rutina_id');
    }
}