<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColaboradoresProyectos extends Model
{
    protected $table = 'colaboradores_proyectos';
    protected $primaryKey = 'idcolproyecto';
    public $timestamps = false;
    protected $fillable = [
        'idProyecto',
        'idColaborador',
    ];

      public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'idProyecto');
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaboradores::class, 'idColaborador');
    }
}
