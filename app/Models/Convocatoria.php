<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convocatoria extends Model
{ 
    protected $table = 'convocatorias';
    protected $primaryKey = 'idConvocatoria';
    public $timestamps = false;

    // Campos actualizados
    protected $fillable = [
        
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'edad',
        'residencia',
        'estatus_convocatoria',
        'estatus',
        'pdf',
        'restricciones',
        'nivel',
        'organizacion',
        'idEstado',
        'fecha_alta',
        'fecha_mod',
        'idUsuario_Alta',
        'idUsuario_Mod',
    ];

    // (Opcional) Relaciones actualizadas: coméntalas si ya no aplican o adáptalas si aún existen
    // Asegúrate de que las columnas referidas existan en la nueva estructura

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoConvocatoria::class, 'idEstado', 'idEstado');
    }


    public function proyectosConvocatoria()
    {
        return $this->hasMany(ProyectoConvocatoria::class, 'idConvocatoria');
    }
    public function pertenencia()
    {
        return $this->hasOne(Pertenece::class, 'idConvocatoria', 'idConvocatoria');
    }

    public function proyectos()
    {
    return $this->belongsToMany(Proyecto::class, 'proyectos_convocatorias', 'idConvocatoria', 'idProyecto')
        ->withPivot('idUsuario_Postula', 'participo', 'estatus_convocatoria', 'estatus'); // ✅ nombres reales
    }
}
