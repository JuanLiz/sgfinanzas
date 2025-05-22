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
        Schema::create('roles_has_modulos', function (Blueprint $table) {
            $table->unsignedBigInteger('rol_idrol');
            $table->unsignedBigInteger('mod_idmodu');
            $table->unsignedBigInteger('per_idper');

            $table->primary(['rol_idrol', 'mod_idmodu', 'per_idper'], 'roles_has_modulos_primary'); // Optional: custom primary key name

            $table->foreign('rol_idrol')->references('idrol')->on('roles')->onDelete('cascade');
            $table->foreign('mod_idmodu')->references('idmodu')->on('modulos')->onDelete('cascade');
            $table->foreign('per_idper')->references('idper')->on('permisos')->onDelete('cascade');

            // No timestamps for this pivot table as per the datamodel.sql
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_has_modulos');
    }
};
