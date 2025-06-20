<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('TblProyectoConvocatoria', function (Blueprint $table) {
            $table->id('IdProyectoConvocatoria');
            $table->foreignId('IdProyecto')->constrained('TblProyecto', 'IdProyecto');
            $table->foreignId('IdConvocatoria')->constrained('TblConvocatoria', 'IdConvocatoria');
            $table->foreignId('IdUsuarioPostula')->constrained('TblUsuario', 'IdUsuario');
            $table->boolean('Participo')->default(false);
            $table->foreignId('EstatusConvocatoria')->constrained('CatEstatus', 'IdStatus');
            $table->boolean('Estatus')->default(true);
            $table->dateTime('FechaAlta');
            $table->dateTime('FechaMod')->nullable();
            $table->foreignId('IdUsuarioMod')->nullable()->constrained('TblUsuario', 'IdUsuario');
        });
    }

    public function down()
    {
        Schema::dropIfExists('TblProyectoConvocatoria');
    }
};