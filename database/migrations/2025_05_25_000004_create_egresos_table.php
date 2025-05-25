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
        Schema::create('egresos', function (Blueprint $table) {
            $table->id('idegr');
            $table->decimal('egres_monto', 15, 2)->comment('Monto del egreso');
            $table->date('egres_fecha')->comment('Fecha en que se realizó el egreso');
            $table->string('egres_descripcion', 255);
            $table->enum('egres_tipo', ['Fijo', 'Variable'])->comment('Tipo de egreso');
            
            // Relaciones
            $table->unsignedBigInteger('usu_idusu'); // Usuario al que pertenece este egreso
            $table->unsignedBigInteger('contpuc_idcontpuc'); // Contrapartida contable asociada
            
            // Estado y registro
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamp('fecha_registro')->nullable()->useCurrent();
            $table->softDeletes(); // Para implementar SoftDeletes

            // Claves foráneas
            $table->foreign('usu_idusu')->references('idusu')->on('usuarios');
            $table->foreign('contpuc_idcontpuc')->references('idcontpuc')->on('contrapartida_puc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egresos');
    }
};
