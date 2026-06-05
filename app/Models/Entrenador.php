<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    use HasFactory;

    protected $table = 'entrenadores';

    protected $fillable = [
        'user_id',
        'sucursal_id',
        'telefono',
        'especialidad',
        'activo',
        'foto_perfil',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_entrenador')
            ->withPivot('fecha_asignacion', 'activo')
            ->withTimestamps();
    }

    public function rutinasAsignadas()
    {
        return $this->hasMany(ClienteRutina::class, 'entrenador_id');
    }
}