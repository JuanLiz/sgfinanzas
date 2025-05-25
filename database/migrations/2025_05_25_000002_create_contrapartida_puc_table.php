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
        Schema::create('contrapartida_puc', function (Blueprint $table) {
            $table->id('idcontpuc');
            $table->string('contpuc_codigo', 6)->unique()->comment('Código de seis dígitos para la contrapartida');
            $table->string('contpuc_descripcion', 255);
            $table->enum('contpuc_tipo', ['Ingreso', 'Egreso'])->comment('Tipo de transacción asociada a esta contrapartida');
            $table->unsignedBigInteger('puc_idpuc');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamp('fecha_registro')->nullable()->useCurrent();
            $table->softDeletes(); // Para implementar SoftDeletes

            // Relación con PUC
            $table->foreign('puc_idpuc')->references('idpuc')->on('pucs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrapartida_puc');
    }
};
