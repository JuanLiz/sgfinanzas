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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('idusu');
            $table->string('usua_nombre', 45);
            // Add email and password for Laravel Auth, make email unique
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->unsignedBigInteger('rol_idrol');
            $table->unsignedBigInteger('muni_idmuni');
            $table->unsignedBigInteger('depar_iddepar');
            $table->enum('estado', ['Activo', 'Inactivo']);
            $table->timestamp('fecha_registro')->nullable()->useCurrent();

            $table->foreign('rol_idrol')->references('idrol')->on('roles')->onDelete('cascade');
            $table->foreign('muni_idmuni')->references('idmuni')->on('municipios')->onDelete('cascade');
            $table->foreign('depar_iddepar')->references('iddepar')->on('departamentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
