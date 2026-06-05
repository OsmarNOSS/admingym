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
        Schema::create('rutinas', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 100);
        $table->text('descripcion')->nullable();
        $table->enum('nivel', ['principiante','intermedio','avanzado'])->default('principiante');
        $table->boolean('es_vip')->default(false);
        $table->boolean('activa')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutinas');
    }
};
