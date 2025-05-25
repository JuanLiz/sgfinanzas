<?php

namespace Database\Seeders;

use App\Models\PUC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PUCCuentasDeOrdenAcreedorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasPUC = [
            ['puc_codigo' => '9105', 'puc_descripcion' => 'Bienes y valores recibidos en custodia', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9110', 'puc_descripcion' => 'Bienes y valores recibidos en garantía', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9115', 'puc_descripcion' => 'Bienes y valores recibidos de terceros', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9120', 'puc_descripcion' => 'Litigios y/o demandas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9125', 'puc_descripcion' => 'Promesas de compraventa', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9130', 'puc_descripcion' => 'Contratos de administración delegada', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9135', 'puc_descripcion' => 'Cuentas en participación', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9195', 'puc_descripcion' => 'Otras responsabilidades contingentes', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9305', 'puc_descripcion' => 'Contratos de arrendamiento financiero', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9395', 'puc_descripcion' => 'Otras cuentas de orden acreedoras de control', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '9399', 'puc_descripcion' => 'Ajustes por inflación patrimonio', 'puc_naturaleza' => 'Acreedora'],
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
        
        $this->command->info('PUC Seeder for CuentasDeOrdenAcreedoras (Class 9) ran successfully!');
    }
}
