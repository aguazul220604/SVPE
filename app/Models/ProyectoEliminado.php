<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoEliminado extends Model
{
    protected $table = 'TblProyectosEliminados';
    protected $primaryKey = 'IdProyectoEliminado';
    public $timestamps = false;

    protected $fillable = [
        'IdProyecto',
        'IdUsuario',
        'FechaElimina',
    ];
}
