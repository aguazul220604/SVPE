<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescripcionProyecto extends Model
{use HasFactory;

            protected $table = 'descripcion_proyectos';
            protected $primaryKey = 'idDescripcion_Proyecto';
            public $timestamps = false;

            protected $fillable = [
                'nombre',
                'propuesta_valor',
                'introduccion',
                'justificacion',
                'descripcion',
                'resumen',
                'objetivos_generales',
                'objetivos_especificos',
                'estado_arte',
                'fortalezas',
                'oportunidades',
                'debilidades',
                'amenazas',
                'metodologias',
                'costos',
                'resultados',
                'referencias',
                'pdf',
                'idEstado',
                'fecha_alta',
                'idUsuario_Alta',
                'fecha_mod',
                'idUsuario_Mod',
            ];

            // Relaciones

            public function estado()
            {
                return $this->belongsTo(Estatus::class, 'idEstado');
            }

            public function proyecto()
            {
                return $this->hasOne(Proyecto::class, 'idDescripcion_Proyecto');
            }
}