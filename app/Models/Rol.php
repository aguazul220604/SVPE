<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'CatRol';
    protected $primaryKey = 'IdRol';
    public $timestamps = false;

    protected $fillable = [
        'Descripcion',
        'Estatus',
        'FechaAlta',
    ];

}
