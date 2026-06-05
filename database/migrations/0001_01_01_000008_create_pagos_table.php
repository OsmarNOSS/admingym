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
        Schema::create('pagos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained('clientes')->restrictOnDelete();
        $table->foreignId('membresia_id')->constrained('membresias')->restrictOnDelete();
        $table->foreignId('sucursal_id')->constrained('sucursales')->restrictOnDelete();
        $table->foreignId('registrado_por')->constrained('users')->restrictOnDelete();
        $table->decimal('monto', 10, 2);
        $table->enum('metodo_pago', ['efectivo','tarjeta','transferencia'])->default('efectivo');
        $table->timestamp('fecha_pago')->useCurrent();
        $table->string('concepto', 255)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
