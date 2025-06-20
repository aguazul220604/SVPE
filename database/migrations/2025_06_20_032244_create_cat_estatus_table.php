<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('CatEstatus', function (Blueprint $table) {
            $table->id('IdStatus');
            $table->string('Descripcion');
            $table->boolean('Estatus')->default(true);
            $table->string('Catalogo')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('CatEstatus');
    }
};