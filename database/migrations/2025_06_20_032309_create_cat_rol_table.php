<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('CatRol', function (Blueprint $table) {
            $table->id('IdRol');
            $table->string('Descripcion');
            $table->boolean('Estatus')->default(true);
            $table->dateTime('FechaAlta');
        });
    }

    public function down()
    {
        Schema::dropIfExists('CatRol');
    }
};
