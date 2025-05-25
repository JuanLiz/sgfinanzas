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
        Schema::create('costos_fijos', function (Blueprint $table) {
            $table->id('idcostofijo');
            $table->decimal('costofijo_monto', 12, 2);
            $table->string('costofijo_descripcion');
            $table->string('costofijo_frecuencia'); // Mensual, Bimestral, Trimestral, Semestral, Anual
            $table->integer('costofijo_dia_mes')->nullable()->comment('Día del mes en que se debe pagar');
            $table->date('costofijo_proximo_pago')->nullable();
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
        Schema::dropIfExists('costos_fijos');
    }
};
