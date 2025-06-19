<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens; // O use Laravel\Passport\HasApiTokens si usas Passport

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'TblUsuario';
    protected $primaryKey = 'IdUsuario';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Matricula',
        'Telefono',
        'Correo',
        'Contrasena',
        'IdCarrera',
        'IdRol',
        'FechaAlta',
        'FechaMod',
        'IdUsuarioMod'
    ];

    protected $hidden = [
        'Contrasena',
        'remember_token',
    ];

    protected $casts = [
        'FechaAlta' => 'datetime',
        'FechaMod' => 'datetime',
    ];

    public function setContrasenaAttribute($value)
    {
        $this->attributes['Contrasena'] = Hash::make($value);
    }


    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'IdCarrera');
    }
    

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'IdRol');
    }


    public function getNombreCompletoAttribute()
    {
        return $this->Nombre;
    }

    public function scopePorMatricula($query, $matricula)
    {
        return $query->where('Matricula', $matricula);
    }

    
    public function scopeActivos($query)
    {
        return $query->where('Estatus', 1);
    }
}