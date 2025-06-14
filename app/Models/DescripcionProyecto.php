<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DescripcionProyecto extends Model
{
    protected $table = 'TblDescripcionProyecto';
    protected $primaryKey = 'IdDescProyecto';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'PropValor',
        'Introduccion',
        'Justificacion',
        'Descripcion',
        'ObjsGrals',
        'ObjsEspec',
        'EdoArte',
        'Fortalezas',
        'Oportunidades',
        'Debilidades',
        'Amenazas',
        'Metodologia',
        'Costos',
        'Resultados',
        'Referencias',
        'Pdf',
        'IdStatus',
        'FechaAlta',
        'FechaMod',
        'IdUsuarioAlta',
        'IdUsuarioMod',
    ];

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'IdStatus', 'IdStatus');
    }
}
