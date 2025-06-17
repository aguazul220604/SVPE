<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
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

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'IdCarrera');
    }
    
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'IdRol');
    }
}
