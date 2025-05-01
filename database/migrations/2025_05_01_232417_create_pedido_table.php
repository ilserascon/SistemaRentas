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
        Schema::create('pedido', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->string('fecha_entrega');
            $table->string('fecha_devolucion');
            $table->string('descripcion');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_maquinaria');
            $table->unsignedBigInteger('id_repartidor');
            $table->unsignedBigInteger('id_estatus_pedido');
            $table->boolean('borrado')->default(0);
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('id_maquinaria')->references('id')->on('maquinaria')->onDelete('cascade');
            $table->foreign('id_repartidor')->references('id')->on('repartidor')->onDelete('cascade');
            $table->foreign('id_estatus_pedido')->references('id')->on('estatus_pedido')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido');
    }
};
