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
            $table->datetime('fecha_en_entrega')->nullable();
            $table->datetime('fecha_entrega_solicitada');
            $table->datetime('fecha_devolucion_solicitada');
            $table->string('observacion')->nullable();
            $table->text('ubicacion_url');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_tipo_maquinaria');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_maquinaria')->nullable();
            $table->unsignedBigInteger('id_repartidor')->nullable();
            $table->unsignedBigInteger('id_estatus_pedido');
            $table->boolean('borrado')->default(0);
            $table->string('foto')->nullable();
            $table->string('firma')->nullable();
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_tipo_maquinaria')->references('id')->on('tipo_maquinaria')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('id_maquinaria')->references('id')->on('maquinaria')->onDelete('cascade');
            $table->foreign('id_repartidor')->references('id')->on('repartidores')->onDelete('cascade');
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
