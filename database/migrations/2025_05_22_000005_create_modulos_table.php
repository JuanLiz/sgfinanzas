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
        Schema::create('modulos', function (Blueprint $table) {
            $table->id('idmodu');
            $table->string('modu_descripcion', 255);
            $table->enum('estado', ['Activo', 'Inactivo']);
            $table->timestamp('fecha_registro')->nullable()->useCurrent();
            // Añadir nuevas columnas para UX
            $table->string('modu_nombre', 100)->after('idmodu')->comment('Nombre corto y descriptivo del módulo'); // Asumiendo que idmodu ya existe o fue renombrado
            $table->string('modu_icono', 50)->nullable()->after('modu_descripcion')->comment('Icono de Heroicons para el módulo');
            $table->integer('modu_orden')->default(0)->after('modu_icono')->comment('Orden de aparición del módulo');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos');
    }
};
