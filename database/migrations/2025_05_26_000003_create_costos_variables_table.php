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
        Schema::create('costos_variables', function (Blueprint $table) {
            $table->id('idcostovariable');
            $table->decimal('costovariable_monto_promedio', 12, 2)->comment('Monto promedio esperado');
            $table->string('costovariable_descripcion');
            $table->string('costovariable_frecuencia'); // Mensual, Bimestral, Trimestral, Semestral, Anual
            $table->decimal('costovariable_variacion', 5, 2)->nullable()->comment('Porcentaje de variación esperada');
            $table->unsignedBigInteger('contpuc_idcontpuc');
            $table->unsignedBigInteger('usu_idusu');
            $table->string('estado')->default('Activo');
            $table->timestamp('fecha_registro')->useCurrent();
            $table->softDeletes();

            $table->foreign('contpuc_idcontpuc')->references('idcontpuc')->on('contrapartida_puc');
            $table->foreign('usu_idusu')->references('idusu')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costos_variables');
    }
};
