<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Estatus;



class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
    protected $primaryKey = 'idProyecto';
    public $timestamps = false;

    protected $fillable = [
        'idConvocatoria',
        'idDescripcion',
        'fecha_registro',
        'fecha_inicio',
        'fecha_fin',
        'fecha_mod',
        'estatus_convocatoria',
        'estatus',
        'financiamiento',
        'idUsuario_Mod',
    ];

    // Relaciones

    public function convocatoria()
    {
        return $this->belongsTo(Convocatoria::class, 'idConvocatoria');
    }

    public function descripcion()
    {
        return $this->belongsTo(DescripcionProyecto::class, 'idDescripcion', 'idDescripcion_Proyecto');
    }

    public function usuarioModificador()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario_Mod', 'idUsuario');
    }
        public function lider()
    {
        return $this->belongsTo(Usuario::class, 'IdUsuario', 'idUsuario'); // ajusta los nombres si son diferentes
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'IdCategoria', 'idCategoria');
    }
    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'IdEstado', 'idEstado');
    }
    
    public function asesor()
    {
        return $this->belongsTo(Usuario::class, 'IdAsesor', 'idUsuario');
    }
    public function getRouteKeyName()
{
    return 'idProyecto';
}
public function colaboradores()
	{
		return $this->belongsToMany(Colaboradores::class, 'colaboradores_proyectos', 'idProyecto', 'idColaborador');
	}


}
