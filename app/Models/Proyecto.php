<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
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

    public function usuarioLider()
    {
        return $this->belongsTo(Usuario::class, 'IdUsuarioLider');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'IdCategoria');
    }
}
