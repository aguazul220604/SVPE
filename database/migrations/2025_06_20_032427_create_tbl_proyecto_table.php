<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('TblProyecto', function (Blueprint $table) {
            $table->id('IdProyecto');
            $table->foreignId('IdUsuarioLider')->constrained('TblUsuario', 'IdUsuario');
            $table->foreignId('IdCategoria')->constrained('CatCategoria', 'IdCategoria');
            $table->foreignId('IdDescripcion')->constrained('TblDescripcionProyecto', 'IdDescProyecto');
            $table->dateTime('FechaAlta');
            $table->dateTime('FechaMod')->nullable();
            $table->foreignId('IdUsuarioMod')->nullable()->constrained('TblUsuario', 'IdUsuario');
        });
    }

    public function down()
    {
        Schema::dropIfExists('TblProyecto');
    }
};