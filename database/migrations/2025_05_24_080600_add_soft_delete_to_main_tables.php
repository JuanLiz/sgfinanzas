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
        // Añadir columna deleted_at a las tablas principales para soft delete
        Schema::table('usuarios', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('departamentos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('municipios', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('departamentos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('municipios', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
