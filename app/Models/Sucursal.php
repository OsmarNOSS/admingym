<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';

    protected $fillable = [
    'nombre',
    'direccion',
    'telefono',
    'capacidad',
    'hora_apertura',
    'hora_cierre',
    'activa',
    'foto_portada',
];

    // Una sucursal tiene muchos usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class, 'sucursal_id');
    }

    // Una sucursal tiene muchos clientes
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'sucursal_id');
    }

    // Una sucursal tiene muchos entrenadores
    public function entrenadores()
    {
        return $this->hasMany(Entrenador::class, 'sucursal_id');
    }

    // Una sucursal tiene muchas membresías
    public function membresias()
    {
        return $this->hasMany(Membresia::class, 'sucursal_id');
    }

    // Una sucursal tiene muchas asistencias
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'sucursal_id');
    }
}