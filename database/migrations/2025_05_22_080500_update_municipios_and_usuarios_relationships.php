<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero: añadimos la columna depar_iddepar a la tabla municipios
        Schema::table('municipios', function (Blueprint $table) {
            $table->unsignedBigInteger('depar_iddepar')->after('muni_nombre')->nullable();
            $table->foreign('depar_iddepar')->references('iddepar')->on('departamentos')->onDelete('cascade');
        });

        // Segundo: Actualización de los municipios existentes con un departamento por defecto
        // Este código es de ejemplo, probablemente quieras asignar los municipios correctamente
        // en un entorno de producción o con datos reales
        DB::statement("UPDATE municipios SET depar_iddepar = (SELECT MIN(iddepar) FROM departamentos WHERE estado = 'Activo' LIMIT 1)");
        
        // Tercero: Hacer que la columna no sea nullable después de asignar valores
        Schema::table('municipios', function (Blueprint $table) {
            $table->unsignedBigInteger('depar_iddepar')->nullable(false)->change();
        });

        // Cuarto: Eliminamos la referencia directa departamento-usuario, ya que ahora es a través del municipio
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['depar_iddepar']);
            $table->dropColumn('depar_iddepar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Primero: Volvemos a agregar la columna depar_iddepar a usuarios
        Schema::table('usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('depar_iddepar')->after('muni_idmuni')->nullable();
            $table->foreign('depar_iddepar')->references('iddepar')->on('departamentos');
        });

        // Segundo: Actualizamos los usuarios con el departamento correspondiente a su municipio
        DB::statement("
            UPDATE usuarios u
            JOIN municipios m ON u.muni_idmuni = m.idmuni
            SET u.depar_iddepar = m.depar_iddepar
        ");

        // Tercero: Hacemos que la columna depar_iddepar no sea nullable en usuarios
        Schema::table('usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('depar_iddepar')->nullable(false)->change();
        });

        // Cuarto: Eliminamos la relación entre municipio y departamento
        Schema::table('municipios', function (Blueprint $table) {
            $table->dropForeign(['depar_iddepar']);
            $table->dropColumn('depar_iddepar');
        });
    }
};
