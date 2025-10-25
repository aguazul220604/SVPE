<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'disciplinas';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion','estatus'];
}