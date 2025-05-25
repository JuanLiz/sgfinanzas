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
        Schema::create('pucs', function (Blueprint $table) {
            $table->id('idpuc');
            $table->string('puc_codigo', 4)->unique()->comment('Código de cuatro dígitos para la cuenta PUC');
            $table->string('puc_descripcion', 255);
            $table->enum('puc_naturaleza', ['Deudora', 'Acreedora'])->comment('Naturaleza contable de la cuenta');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamp('fecha_registro')->nullable()->useCurrent();
            $table->softDeletes(); // Para implementar SoftDeletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pucs');
    }
};
