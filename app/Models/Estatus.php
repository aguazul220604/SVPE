<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
    protected $table = 'CatEstatus';
    protected $primaryKey = 'IdStatus';
    public $timestamps = false;

    protected $fillable = ['Descripcion', 'Estatus', 'Catalogo'];
}