<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'TblProyecto';
    protected $primaryKey = 'IdProyecto';
    public $timestamps = false;

    protected $fillable = [
        'IdUsuarioLider',
        'IdCategoria',
        'IdDescripcion',
        'FechaAlta',
        'FechaMod',
        'IdUsuarioMod',
    ];

    public function lider()
    {
        return $this->belongsTo(TblUsuario::class, 'IdUsuarioLider');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'IdCategoria');
    }

    public function descripcion()
    {
        return $this->belongsTo(DescripcionProyecto::class, 'IdDescripcion');
    }

    public function integrantes()
    {
        return $this->hasMany(IntegranteProyecto::class, 'IdProyecto');
    }

    public function convocatorias()
    {
        return $this->belongsToMany(Convocatoria::class, 'TblProyectoConvocatoria', 'IdProyecto', 'IdConvocatoria')
            ->withPivot('IdUsuarioPostula', 'Participo', 'EstatusConvocatoria', 'Estatus');
    }
}