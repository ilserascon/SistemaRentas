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
        Schema::create('mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_falla');
            $table->unsignedBigInteger('id_maquinaria');
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_encargado');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('id_falla')->references('id')->on('fallas')->onDelete('cascade');
            $table->foreign('id_maquinaria')->references('id')->on('maquinaria')->onDelete('cascade');
            $table->foreign('id_pedido')->references('id')->on('pedido')->onDelete('cascade');
            $table->foreign('id_encargado')->references('id')->on('mecanico')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento');
    }
};
