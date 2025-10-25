<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoConvocatoria extends Model
{
    protected $table = 'estados_convocatorias'; // O usa 'estados_proyectos' si es la misma tabla
    protected $primaryKey = 'idEstado';
    public $timestamps = false;

    protected $fillable = ['descripcion', 'catalogo'];

     public function getNombreAttribute()
    {
        return $this->descripcion;
    }
}