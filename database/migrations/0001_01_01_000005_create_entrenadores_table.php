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
        Schema::create('entrenadores', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
    $table->foreignId('sucursal_id')->nullable()->constrained('sucursales')->nullOnDelete();
    $table->string('telefono', 20)->nullable();
    $table->string('especialidad', 100)->nullable();
    $table->boolean('activo')->default(true);
    $table->timestamps();
});
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrenadores');
    }
};
