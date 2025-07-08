<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'CatCategoria';
    protected $primaryKey = 'IdCategoria';
    public $timestamps = false;

    protected $fillable = ['Descripcion', 'Estatus'];
}