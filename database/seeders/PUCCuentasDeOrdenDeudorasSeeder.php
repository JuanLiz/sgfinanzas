<?php

namespace Database\Seeders;

use App\Models\PUC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PUCCuentasDeOrdenDeudorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasPUC = [
            ['puc_codigo' => '8105', 'puc_descripcion' => 'Bienes y valores entregados en custodia', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8110', 'puc_descripcion' => 'Bienes y valores entregados en garantía', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8115', 'puc_descripcion' => 'Bienes y valores en poder de terceros', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8120', 'puc_descripcion' => 'Litigios y/o demandas', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8125', 'puc_descripcion' => 'Promesas de compraventa', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8195', 'puc_descripcion' => 'Diversas', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8305', 'puc_descripcion' => 'Bienes recibidos en arrendamiento financiero', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8310', 'puc_descripcion' => 'Títulos de inversión no colocados', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8315', 'puc_descripcion' => 'Propiedades, planta y equipo totalmente depreciados, agotados y/o amortizados', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8320', 'puc_descripcion' => 'Créditos a favor no utilizados', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8325', 'puc_descripcion' => 'Activos castigados', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8330', 'puc_descripcion' => 'Títulos de inversión amortizados', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8335', 'puc_descripcion' => 'Capitalización por revalorización de patrimonio', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8395', 'puc_descripcion' => 'Otras cuentas deudoras de control', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '8399', 'puc_descripcion' => 'Ajustes por inflación activos', 'puc_naturaleza' => 'Deudora'],
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
        
        $this->command->info('PUC Seeder for CuentasDeOrdenDeudoras (Class 8) ran successfully!');
    }
}
