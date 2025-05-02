<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maquinaria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('numero_serie');
            $table->string('modelo');
            $table->string('descripcion');
            $table->unsignedBigInteger('id_tipo_maquinaria');
            $table->unsignedBigInteger('id_almacen');
            $table->boolean('borrado')->default(0);
            $table->timestamps();

            $table->foreign('id_tipo_maquinaria')->references('id')->on('tipo_maquinaria')->onDelete('cascade');
            $table->foreign('id_almacen')->references('id')->on('almacen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinaria');
    }
};
