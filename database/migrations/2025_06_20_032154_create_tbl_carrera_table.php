<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('TblCarrera', function (Blueprint $table) {
            $table->id('IdCarrera');
            $table->string('Descripcion');
            $table->dateTime('FechaReg');
            $table->dateTime('FechaMod')->nullable();
            $table->boolean('Estatus')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('TblCarrera');
    }
};
