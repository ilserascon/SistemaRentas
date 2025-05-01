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
        Schema::create('tipo_maquinaria', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->timestamps();
        });

        DB::table('tipo_maquinaria')->insert([
            ['descripcion' => 'Tipo Uno'],
            ['descripcion' => 'Tipo Dos'],
            ['descripcion' => 'Tipo Tres'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_maquinaria');
    }
};
