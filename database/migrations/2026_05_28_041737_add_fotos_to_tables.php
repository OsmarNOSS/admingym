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
    Schema::table('clientes', function (Blueprint $table) {
        $table->string('foto_perfil')->nullable()->after('activo');
    });

    Schema::table('entrenadores', function (Blueprint $table) {
        $table->string('foto_perfil')->nullable()->after('activo');
    });

    Schema::table('sucursales', function (Blueprint $table) {
        $table->string('foto_portada')->nullable()->after('activa');
    });

    Schema::table('rutinas', function (Blueprint $table) {
        $table->string('foto_portada')->nullable()->after('activa');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('clientes', function (Blueprint $table) {
        $table->dropColumn('foto_perfil');
    });

    Schema::table('entrenadores', function (Blueprint $table) {
        $table->dropColumn('foto_perfil');
    });

    Schema::table('sucursales', function (Blueprint $table) {
        $table->dropColumn('foto_portada');
    });

    Schema::table('rutinas', function (Blueprint $table) {
        $table->dropColumn('foto_portada');
    });
}
};
