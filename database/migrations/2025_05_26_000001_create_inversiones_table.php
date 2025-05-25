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
        Schema::create('inversiones', function (Blueprint $table) {
            $table->id('idinversion');
            $table->decimal('inversion_monto', 12, 2);
            $table->date('inversion_fecha');
            $table->string('inversion_descripcion');
            $table->string('inversion_tipo');
            $table->decimal('inversion_rendimiento_esperado', 5, 2)->nullable()->comment('Porcentaje de rendimiento esperado');
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
        Schema::dropIfExists('inversiones');
    }
};
