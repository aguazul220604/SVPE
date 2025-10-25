<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'idUsuario';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'matricula',
        'telefono_institucional',
        'extension',
        'celular',
        'correo_institucional',
        'correo_adicional',
        'contrasena',
        'idInstitucion',
        'idRol',
        'fecha_alta',
        'fecha_mod',
        'idUsuario_Mod',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    // Para autenticación
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function setContrasenaAttribute($value)
    {
        $this->attributes['contrasena'] = Hash::make($value);
    }

    // Accesor para el nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    // Relaciones (si existen)
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'idInstitucion');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol');
    }

    public function modificador()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario_Mod');
    }
}
