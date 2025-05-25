<?php

namespace Database\Seeders;

use App\Models\PUC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PUCGastosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasPUC = [
            ['puc_codigo' => '5105', 'puc_descripcion' => 'Gastos de personal', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5110', 'puc_descripcion' => 'Honorarios', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5115', 'puc_descripcion' => 'Impuestos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5120', 'puc_descripcion' => 'Arrendamientos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5125', 'puc_descripcion' => 'Contribuciones y afiliaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5130', 'puc_descripcion' => 'Seguros', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5135', 'puc_descripcion' => 'Servicios', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5140', 'puc_descripcion' => 'Gastos legales', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5145', 'puc_descripcion' => 'Mantenimiento y reparaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5150', 'puc_descripcion' => 'Adecuación e instalación', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5155', 'puc_descripcion' => 'Gastos de viaje', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5160', 'puc_descripcion' => 'Depreciaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5165', 'puc_descripcion' => 'Amortizaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5195', 'puc_descripcion' => 'Diversos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5199', 'puc_descripcion' => 'Provisiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5205', 'puc_descripcion' => 'Gastos de personal', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5210', 'puc_descripcion' => 'Honorarios', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5215', 'puc_descripcion' => 'Impuestos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5220', 'puc_descripcion' => 'Arrendamientos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5225', 'puc_descripcion' => 'Contribuciones y afiliaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5230', 'puc_descripcion' => 'Seguros', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5235', 'puc_descripcion' => 'Servicios', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5240', 'puc_descripcion' => 'Gastos legales', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5245', 'puc_descripcion' => 'Mantenimiento y reparaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5250', 'puc_descripcion' => 'Adecuación e instalación', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5255', 'puc_descripcion' => 'Gastos de viaje', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5260', 'puc_descripcion' => 'Depreciaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5265', 'puc_descripcion' => 'Amortizaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5270', 'puc_descripcion' => 'Financieros-reajuste del sistema', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5275', 'puc_descripcion' => 'Pérdidas método de participación', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5295', 'puc_descripcion' => 'Diversos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5299', 'puc_descripcion' => 'Provisiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5305', 'puc_descripcion' => 'Financieros', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5310', 'puc_descripcion' => 'Pérdida en venta y retiro de bienes', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5313', 'puc_descripcion' => 'Pérdidas método de participación', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5315', 'puc_descripcion' => 'Gastos extraordinarios', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5395', 'puc_descripcion' => 'Gastos diversos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5405', 'puc_descripcion' => 'Impuesto de renta y complementarios', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '5905', 'puc_descripcion' => 'Ganancias y pérdidas', 'puc_naturaleza' => 'Deudora'],
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
        
        $this->command->info('PUC Seeder for Gastos (Class 5) ran successfully!');
    }
}
