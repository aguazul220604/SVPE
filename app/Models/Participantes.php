<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participantes extends Model
{
    protected $table = 'participantes';
    protected $primaryKey = 'idParticipantes';
    public $timestamps = false;

    protected $fillable = [
        'idUsuario',
        'idProyecto', 
        'lider',
        'nivel',
        'tipo_participacion',
        
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'idProyecto');
    }
    public function usuario()
{
    return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
}

}
