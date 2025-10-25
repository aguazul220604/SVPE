<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
    protected $table = 'estados_proyectos';
    protected $primaryKey = 'idEstado';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion'];
}