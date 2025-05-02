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
        Schema::create('estatus_pedido', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->timestamps();
        });

        DB::table('estatus_pedido')->insert([
            ['descripcion' => 'Solicitado'],
            ['descripcion' => 'Asignado'],
            ['descripcion' => 'En Entrega'],
            ['descripcion' => 'En Renta'],
            ['descripcion' => 'Terminado'],
            ['descripcion' => 'Cancelado'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estatus_pedido');
    }
};
