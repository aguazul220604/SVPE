<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('TblUsuario', function (Blueprint $table) {
            $table->id('IdUsuario');
            $table->string('Nombre');
            $table->string('Matricula')->unique();
            $table->string('Telefono')->nullable();
            $table->string('Correo')->unique();
            $table->string('Contrasena');
            $table->foreignId('IdCarrera')->constrained('TblCarrera', 'IdCarrera');
            $table->foreignId('IdRol')->constrained('CatRol', 'IdRol');
            $table->dateTime('FechaAlta');
            $table->dateTime('FechaMod')->nullable();
            $table->foreignId('IdUsuarioMod')->nullable()->constrained('TblUsuario', 'IdUsuario');
            $table->rememberToken();
            $table->boolean('Estatus')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('TblUsuario');
    }
};
