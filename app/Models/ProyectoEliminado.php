<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoEliminado extends Model
{
    protected $table = 'proyectos_eliminados';
    protected $primaryKey = 'IdProyecto_Eliminado';
    public $timestamps = false;

    protected $fillable = [
        'idProyecto',
        'idUsuario',
        'fecha_elimina',
    ];
}
