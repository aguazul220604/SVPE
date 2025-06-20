<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('TblDescripcionProyecto', function (Blueprint $table) {
            $table->id('IdDescProyecto');
            $table->string('Nombre');
            $table->text('PropValor')->nullable();
            $table->text('Introduccion')->nullable();
            $table->text('Justificacion')->nullable();
            $table->text('Descripcion')->nullable();
            $table->text('ObjsGrals')->nullable();
            $table->text('ObjsEspec')->nullable();
            $table->text('EdoArte')->nullable();
            $table->text('Fortalezas')->nullable();
            $table->text('Oportunidades')->nullable();
            $table->text('Debilidades')->nullable();
            $table->text('Amenazas')->nullable();
            $table->text('Metodologia')->nullable();
            $table->text('Costos')->nullable();
            $table->text('Resultados')->nullable();
            $table->text('Referencias')->nullable();
            $table->string('Pdf')->nullable();
            $table->foreignId('IdStatus')->constrained('CatEstatus', 'IdStatus');
            $table->dateTime('FechaAlta');
            $table->dateTime('FechaMod')->nullable();
            $table->foreignId('IdUsuarioAlta')->constrained('TblUsuario', 'IdUsuario');
            $table->foreignId('IdUsuarioMod')->nullable()->constrained('TblUsuario', 'IdUsuario');
        });
    }

    public function down()
    {
        Schema::dropIfExists('TblDescripcionProyecto');
    }
};
