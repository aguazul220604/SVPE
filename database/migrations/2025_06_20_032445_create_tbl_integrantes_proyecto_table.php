<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('TblIntegrantesProyecto', function (Blueprint $table) {
            $table->id('IdIntegrProy');
            $table->string('Nombre');
            $table->string('Matricula');
            $table->foreignId('IdProyecto')->constrained('TblProyecto', 'IdProyecto');
            $table->dateTime('FechaAlta');
            $table->dateTime('FechaMod')->nullable();
            $table->foreignId('IdUsuarioAlta')->constrained('TblUsuario', 'IdUsuario');
            $table->foreignId('IdUsuarioMod')->nullable()->constrained('TblUsuario', 'IdUsuario');
            $table->boolean('Estatus')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('TblIntegrantesProyecto');
    }
};