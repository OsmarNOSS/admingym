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
        Schema::create('membresias', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
        $table->foreignId('sucursal_id')->constrained('sucursales')->restrictOnDelete();
        $table->enum('tipo', ['basic','premium','vip']);
        $table->date('fecha_inicio');
        $table->date('fecha_fin');
        $table->boolean('activa')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membresias');
    }
};
