<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colaboradores extends Model
{
    protected $table = 'colaboradores';
    protected $primaryKey = 'idColaborador';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'matricula',
        'grado'

    ];

    public function colaborador()
    {
        return $this->belongsTo(Usuario::class, 'idColaborador');
    }
    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'colaboradores_proyectos', 'idColaborador', 'idProyecto');
    }
}
