<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TblUsuario extends Authenticatable
{
    protected $table = 'TblUsuario';
    protected $primaryKey = 'IdUsuario';
    public $timestamps = false;

    protected $fillable = ['Correo', 'Contrasena'];
    
    public function getAuthPassword()
    {
        return $this->Contrasena;
    }
}

