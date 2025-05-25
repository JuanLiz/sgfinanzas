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
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id('iding');
            $table->decimal('ingre_monto', 15, 2)->comment('Monto del ingreso');
            $table->date('ingre_fecha')->comment('Fecha en que se recibió el ingreso');
            $table->string('ingre_descripcion', 255);
            
            // Relaciones
            $table->unsignedBigInteger('usu_idusu'); // Usuario al que pertenece este ingreso
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
        Schema::dropIfExists('ingresos');
    }
};
