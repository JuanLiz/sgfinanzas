<?php

namespace Database\Seeders;

use App\Models\ContrapartidaPUC;
use App\Models\PUC; // To lookup parent PUC ID
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log; // For logging if parent PUC not found

class ContrapartidaPUCCuentasDeOrdenAcreedorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasContrapartida = [
            ['contpuc_codigo' => '910505', 'contpuc_descripcion' => 'Valores mobiliarios', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9105'],
            ['contpuc_codigo' => '910510', 'contpuc_descripcion' => 'Bienes muebles', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9105'],
            ['contpuc_codigo' => '910599', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9105'],
            ['contpuc_codigo' => '911005', 'contpuc_descripcion' => 'Valores mobiliarios', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9110'],
            ['contpuc_codigo' => '911010', 'contpuc_descripcion' => 'Bienes muebles', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9110'],
            ['contpuc_codigo' => '911015', 'contpuc_descripcion' => 'Bienes inmuebles', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9110'],
            ['contpuc_codigo' => '911020', 'contpuc_descripcion' => 'Contratos de ganado en participación', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9110'],
            ['contpuc_codigo' => '911099', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9110'],
            ['contpuc_codigo' => '911505', 'contpuc_descripcion' => 'En arrendamiento', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9115'],
            ['contpuc_codigo' => '911510', 'contpuc_descripcion' => 'En préstamo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9115'],
            ['contpuc_codigo' => '911515', 'contpuc_descripcion' => 'En depósito', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9115'],
            ['contpuc_codigo' => '911520', 'contpuc_descripcion' => 'En consignación', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9115'],
            ['contpuc_codigo' => '911525', 'contpuc_descripcion' => 'En comodato', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9115'],
            ['contpuc_codigo' => '911599', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9115'],
            ['contpuc_codigo' => '912005', 'contpuc_descripcion' => 'Laborales', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9120'],
            ['contpuc_codigo' => '912010', 'contpuc_descripcion' => 'Civiles', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9120'],
            ['contpuc_codigo' => '912015', 'contpuc_descripcion' => 'Administrativos o arbitrales', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9120'],
            ['contpuc_codigo' => '912020', 'contpuc_descripcion' => 'Tributarios', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9120'],
            ['contpuc_codigo' => '930505', 'contpuc_descripcion' => 'Bienes muebles', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9305'],
            ['contpuc_codigo' => '930510', 'contpuc_descripcion' => 'Bienes inmuebles', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9305'],
            ['contpuc_codigo' => '939505', 'contpuc_descripcion' => 'Documentos por cobrar descontados', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9395'],
            ['contpuc_codigo' => '939510', 'contpuc_descripcion' => 'Convenios de pago', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9395'],
            ['contpuc_codigo' => '939515', 'contpuc_descripcion' => 'Contratos de construcciones e instalaciones por ejecutar', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9395'],
            ['contpuc_codigo' => '939525', 'contpuc_descripcion' => 'Adjudicaciones pendientes de legalizar', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9395'],
            ['contpuc_codigo' => '939530', 'contpuc_descripcion' => 'Reserva artículo 3º Ley 4ª de 1980', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9395'],
            ['contpuc_codigo' => '939535', 'contpuc_descripcion' => 'Reserva costo reposición semovientes', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9395'],
            ['contpuc_codigo' => '939595', 'contpuc_descripcion' => 'Diversas', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9395'],
            ['contpuc_codigo' => '939599', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9395'],
            ['contpuc_codigo' => '939905', 'contpuc_descripcion' => 'Capital social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9399'],
            ['contpuc_codigo' => '939910', 'contpuc_descripcion' => 'Superávit de capital', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9399'],
            ['contpuc_codigo' => '939915', 'contpuc_descripcion' => 'Reservas', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9399'],
            ['contpuc_codigo' => '939925', 'contpuc_descripcion' => 'Dividendos o participaciones decretadas en acciones, cuotas o partes de interés social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9399'],
            ['contpuc_codigo' => '939930', 'contpuc_descripcion' => 'Resultados de ejercicios anteriores', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '9399'],
        ];

        $fecha = Carbon::now();

        foreach ($cuentasContrapartida as $cuenta) {
            $parentPUC = PUC::where('puc_codigo', $cuenta['parent_puc_codigo'])->first();

            if (!$parentPUC) {
                Log::warning("Parent PUC with code " . $cuenta['parent_puc_codigo'] . " not found for contrapartida " . $cuenta['contpuc_codigo'] . ". Skipping.");
                $this->command->error("Parent PUC with code " . $cuenta['parent_puc_codigo'] . " not found for contrapartida " . $cuenta['contpuc_codigo'] . ". Skipping.");
                continue;
            }

            ContrapartidaPUC::firstOrCreate(
                ['contpuc_codigo' => $cuenta['contpuc_codigo']], // Check if already exists
                [
                    'contpuc_descripcion' => $cuenta['contpuc_descripcion'],
                    'contpuc_tipo' => $cuenta['contpuc_tipo'],
                    'puc_idpuc' => $parentPUC->idpuc,
                    'estado' => 'Activo',
                    'fecha_registro' => $fecha,
                ]
            );
        }
        
        $this->command->info('ContrapartidaPUC Seeder for CuentasDeOrdenAcreedoras (Class 9) ran successfully!');
    }
}
