<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegranteProyecto extends Model
{
    protected $table = 'TblIntegrantesProyecto';
    protected $primaryKey = 'IdIntegrProy';
    public $timestamps = false;

    protected $fillable = [
        'Nombre', 
        'Matricula', 
        'IdProyecto',
        'FechaAlta', 
        'FechaMod', 
        'IdUsuarioAlta', 
        'IdUsuarioMod', 
        'Estatus'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'IdProyecto', 'IdProyecto');
    }
}
