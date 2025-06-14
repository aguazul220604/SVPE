<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convocatoria extends Model
{
    protected $table = 'TblConvocatoria';
    protected $primaryKey = ' IdConvocatoria';
    public $timestamps = false;

    protected $fillable = [
        'FechaInicio',
        'FechaFin',
        'Edad',
        'residencia',
        'Pdf',
        'RestriccionPart',
        'IdCategoria',
        'IdEstatus',
        'Estatus',
        'FechaAlta',
        'FechaMod',
        'IdUsuarioAlta',
        'IdUsuarioMod',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'IdCategoria');
    }
    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'IdEstatus');
    }
}
