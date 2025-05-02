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
        Schema::create('fallas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tipo_falla');
            $table->unsignedBigInteger('id_clasificacion_falla');
            $table->unsignedBigInteger('id_maquinaria');
            $table->unsignedBigInteger('id_pedido');
            $table->timestamps();

            $table->foreign('id_tipo_falla')->references('id')->on('tipo_fallas')->onDelete('cascade');
            $table->foreign('id_clasificacion_falla')->references('id')->on('clasificacion_fallas')->onDelete('cascade');
            $table->foreign('id_maquinaria')->references('id')->on('maquinaria')->onDelete('cascade');
            $table->foreign('id_pedido')->references('id')->on('pedido')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fallas');
    }
};
