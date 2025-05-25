<?php

namespace Database\Seeders;

use App\Models\PUC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PUCIngresosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasPUC = [
            ['puc_codigo' => '4105', 'puc_descripcion' => 'Agricultura, ganadería, caza y silvicultura', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4110', 'puc_descripcion' => 'Pesca', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4115', 'puc_descripcion' => 'Explotación de minas y canteras', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4120', 'puc_descripcion' => 'Industrias manufactureras', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4125', 'puc_descripcion' => 'Suministro de electricidad, gas y agua', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4130', 'puc_descripcion' => 'Construcción', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4135', 'puc_descripcion' => 'Comercio al por mayor y al por menor', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4140', 'puc_descripcion' => 'Hoteles y restaurantes', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4145', 'puc_descripcion' => 'Transporte, almacenamiento y comunicaciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4150', 'puc_descripcion' => 'Actividad financiera', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4155', 'puc_descripcion' => 'Actividades inmobiliarias, empresariales y de alquiler', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4160', 'puc_descripcion' => 'Enseñanza', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4165', 'puc_descripcion' => 'Servicios sociales y de salud', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4170', 'puc_descripcion' => 'Otras actividades de servicios comunitarios, sociales y personales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4175', 'puc_descripcion' => 'Devoluciones  en ventas (DB)', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4205', 'puc_descripcion' => 'Otras ventas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4210', 'puc_descripcion' => 'Financieros', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4215', 'puc_descripcion' => 'Dividendos y participaciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4218', 'puc_descripcion' => 'Ingresos método de participación', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4220', 'puc_descripcion' => 'Arrendamientos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4225', 'puc_descripcion' => 'Comisiones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4230', 'puc_descripcion' => 'Honorarios', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4235', 'puc_descripcion' => 'Servicios', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4240', 'puc_descripcion' => 'Utilidad en venta de inversiones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4245', 'puc_descripcion' => 'Utilidad en venta de propiedades, planta y equipo', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4248', 'puc_descripcion' => 'Utilidad en venta de otros bienes', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4250', 'puc_descripcion' => 'Recuperaciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4255', 'puc_descripcion' => 'Indemnizaciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4260', 'puc_descripcion' => 'Participaciones en concesiones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4265', 'puc_descripcion' => 'Ingresos de ejercicios anteriores', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4275', 'puc_descripcion' => 'Devoluciones en otras ventas (DB)', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4295', 'puc_descripcion' => 'Diversos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '4705', 'puc_descripcion' => 'Corrección monetaria', 'puc_naturaleza' => 'Acreedora'],
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
        
        $this->command->info('PUC Seeder for Ingresos (Class 4) ran successfully!');
    }
}
