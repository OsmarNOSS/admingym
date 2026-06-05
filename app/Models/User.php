<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles; //lo agregue para que pueda asignar rol aca en terminal

    protected $fillable = ['name', 'email', 'password', 'rol', 'sucursal_id'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Un usuario pertenece a una sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    // Un usuario puede ser un cliente (1:1)
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'user_id');
    }

    // Un usuario puede ser un entrenador (1:1)
    public function entrenador()
    {
        return $this->hasOne(Entrenador::class, 'user_id');
    }

    //PARA EL LOGIN 
    public function initials(): string
    {
    return collect(explode(' ', $this->name))
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->implode('');
    }
}