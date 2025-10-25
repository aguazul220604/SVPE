<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('TblProyectosEliminados', function (Blueprint $table) {
            $table->id('IdProyectoEliminado');
            $table->foreignId('IdProyecto')->constrained('TblProyecto', 'IdProyecto');
            $table->foreignId('IdUsuario')->constrained('TblUsuario', 'IdUsuario');
            $table->dateTime('FechaElimina');
        });
    }

    public function down()
    {
        Schema::dropIfExists('TblProyectosEliminados');
    }
};