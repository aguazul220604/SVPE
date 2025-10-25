<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertenece extends Model
{
    protected $table = 'pertenecen';

    public $timestamps = false; // Si no usas timestamps en esta tabla

    protected $fillable = [
        'idConvocatoria',
        'idCategoria',
    ];

    public function convocatoria()
    {
        return $this->belongsTo(Convocatoria::class, 'idConvocatoria');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }
}
