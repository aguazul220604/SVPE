<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'TblCarrera';
    protected $primaryKey = 'IdCarrera';
    public $timestamps = false;

    protected $fillable = [
        'Descripcion',
        'FechaReg', 
        'FechaMod', 
        'Estatus'
    ];
}
