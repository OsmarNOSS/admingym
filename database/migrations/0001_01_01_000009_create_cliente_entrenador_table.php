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
        Schema::create('cliente_entrenador', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
        $table->foreignId('entrenador_id')->constrained('entrenadores')->cascadeOnDelete();
        $table->date('fecha_asignacion');
        $table->boolean('activo')->default(true);
        $table->unique(['cliente_id', 'entrenador_id']);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_entrenador');
    }
};
