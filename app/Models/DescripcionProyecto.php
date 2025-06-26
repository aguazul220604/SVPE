<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescripcionProyecto extends Model
{
    use HasFactory;

    protected $table = 'TblDescripcionProyecto';
    protected $primaryKey = 'IdDescProyecto';
    public $timestamps = false;

    protected $fillable = [
        // ... (todos los campos que tienes en la tabla)
    ];

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'IdStatus');
    }

    public function proyecto()
    {
        return $this->hasOne(Proyecto::class, 'IdDescripcion');
    }
}