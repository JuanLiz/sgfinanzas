<?php

namespace Database\Seeders;

use App\Models\PUC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PUCPatrimonioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasPUC = [
            ['puc_codigo' => '3105', 'puc_descripcion' => 'Capital suscrito y pagado', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3115', 'puc_descripcion' => 'Aportes sociales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3120', 'puc_descripcion' => 'Capital asignado', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3125', 'puc_descripcion' => 'Inversión suplementaria al capital asignado', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3130', 'puc_descripcion' => 'Capital de personas naturales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3135', 'puc_descripcion' => 'Aportes del Estado', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3140', 'puc_descripcion' => 'Fondo social', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3205', 'puc_descripcion' => 'Prima en colocación de acciones, cuotas o partes de interés social', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3210', 'puc_descripcion' => 'Donaciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3215', 'puc_descripcion' => 'Crédito mercantil', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3220', 'puc_descripcion' => 'Know how', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3225', 'puc_descripcion' => 'Superávit método de participación', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3305', 'puc_descripcion' => 'Reservas obligatorias', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3310', 'puc_descripcion' => 'Reservas estatutarias', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3315', 'puc_descripcion' => 'Reservas ocasionales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3405', 'puc_descripcion' => 'Ajustes por inflación', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3410', 'puc_descripcion' => 'Saneamiento fiscal', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3415', 'puc_descripcion' => 'Ajustes por inflación Decreto 3019 de 1989', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3505', 'puc_descripcion' => 'Dividendos decretados en acciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3510', 'puc_descripcion' => 'Participaciones decretadas en cuotas o partes de interés social', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3605', 'puc_descripcion' => 'Utilidad del ejercicio', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3610', 'puc_descripcion' => 'Pérdida del ejercicio', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3705', 'puc_descripcion' => 'Utilidades acumuladas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3710', 'puc_descripcion' => 'Pérdidas acumuladas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3805', 'puc_descripcion' => 'De inversiones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3810', 'puc_descripcion' => 'De propiedades, planta y equipo', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '3895', 'puc_descripcion' => 'De otros activos', 'puc_naturaleza' => 'Acreedora'],
        ];

        $fecha = Carbon::now();

        foreach ($cuentasPUC as $cuenta) {
            PUC::firstOrCreate(
                ['puc_codigo' => $cuenta['puc_codigo']], // Check if already exists
                [
                    'puc_descripcion' => $cuenta['puc_descripcion'],
                    'puc_naturaleza' => $cuenta['puc_naturaleza'],
                    'estado' => 'Activo',
                    'fecha_registro' => $fecha,
                ]
            );
        }
        
        $this->command->info('PUC Seeder for Patrimonio (Class 3) ran successfully!');
    }
}
