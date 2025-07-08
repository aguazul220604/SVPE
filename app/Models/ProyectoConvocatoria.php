<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoConvocatoria extends Model
{
    protected $table = 'TblProyectoConvocatoria';
    protected $primaryKey = 'IdProyectoConvocatoria';
    public $timestamps = false;

    protected $fillable = [
        'IdProyecto',
        'IdConvocatoria',
        'IdUsuarioPostula',
        'Participo',
        'EstatusConvocatoria',
        'Estatus',
        'FechaAlta',
        'FechaMod',
        'IdUsuarioMod',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'IdProyecto');
    }

    public function convocatoria()
    {
        return $this->belongsTo(Convocatoria::class, 'IdConvocatoria');
    }

    public function usuarioPostula()
    {
        return $this->belongsTo(Usuario::class, 'IdUsuarioPostula');
    }
}