<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'instituciones';
    protected $primaryKey = 'idInstitucion';

    // Laravel no gestionará automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'rfc',
        'fecha_registro',
        'fecha_mod',
        'estatus'
    ];
}
