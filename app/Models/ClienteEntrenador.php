<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteEntrenador extends Model
{
    use HasFactory;

    protected $table = 'cliente_entrenador';

    protected $fillable = [
        'cliente_id',
        'entrenador_id',
        'fecha_asignacion',
        'activo',
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'activo' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class, 'entrenador_id');
    }
}