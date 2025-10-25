<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoConvocatoria extends Model
{
    protected $table = 'proyectos_convocatorias';
    protected $primaryKey = 'IdProyecto_Convocatoria';
    public $timestamps = false;

    protected $fillable = [
        'idProyecto',
        'idConvocatoria',
        'idUsuario_Postula',
        'participo',
        'estatus_convocatoria',
        'estatus',
        'fecha_alta',
        'fecha_mod',
        'idUsuario_Mod',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'idProyecto');
    }

    public function convocatoria()
    {
        return $this->belongsTo(Convocatoria::class, 'idConvocatoria');
    }

    public function usuarioPostula()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario_Postula', 'idUsuario');
    }
}