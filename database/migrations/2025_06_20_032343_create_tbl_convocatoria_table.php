<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('TblConvocatoria', function (Blueprint $table) {
            $table->id('IdConvocatoria');
            $table->date('FechaInicio');
            $table->date('FechaFin');
            $table->integer('Edad')->nullable();
            $table->string('residencia')->nullable();
            $table->string('Pdf')->nullable();
            $table->text('RestriccionPart')->nullable();
            $table->foreignId('IdCategoria')->constrained('CatCategoria', 'IdCategoria');
            $table->foreignId('IdEstatus')->constrained('CatEstatus', 'IdStatus');
            $table->boolean('Estatus')->default(true);
            $table->dateTime('FechaAlta');
            $table->dateTime('FechaMod')->nullable();
            $table->foreignId('IdUsuarioAlta')->constrained('TblUsuario', 'IdUsuario');
            $table->foreignId('IdUsuarioMod')->nullable()->constrained('TblUsuario', 'IdUsuario');
        });
    }

    public function down()
    {
        Schema::dropIfExists('TblConvocatoria');
    }
};
