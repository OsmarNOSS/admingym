<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteRutina extends Model
{
    use HasFactory;

    protected $table = 'cliente_rutina';

    protected $fillable = [
        'cliente_id',
        'rutina_id',
        'entrenador_id',
        'fecha_asignacion',
        'activa',
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'activa' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function rutina()
    {
        return $this->belongsTo(Rutina::class, 'rutina_id');
    }

    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class, 'entrenador_id');
    }
}