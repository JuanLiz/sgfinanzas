<?php

namespace Database\Seeders;

use App\Models\PUC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PUCCostosDeVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasPUC = [
            ['puc_codigo' => '6105', 'puc_descripcion' => 'Agricultura, ganadería, caza y silvicultura', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6110', 'puc_descripcion' => 'Pesca', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6115', 'puc_descripcion' => 'Explotación de minas y canteras', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6120', 'puc_descripcion' => 'Industrias manufactureras', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6125', 'puc_descripcion' => 'Suministro de electricidad, gas y agua', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6130', 'puc_descripcion' => 'Construcción', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6135', 'puc_descripcion' => 'Comercio al por mayor y al por menor', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6140', 'puc_descripcion' => 'Hoteles y restaurantes', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6145', 'puc_descripcion' => 'Transporte, almacenamiento y comunicaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6150', 'puc_descripcion' => 'Actividad financiera', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6155', 'puc_descripcion' => 'Actividades inmobiliarias, empresariales y de alquiler', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6160', 'puc_descripcion' => 'Enseñanza', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6165', 'puc_descripcion' => 'Servicios sociales y de salud', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6170', 'puc_descripcion' => 'Otras actividades de servicios comunitarios, sociales y personales', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6205', 'puc_descripcion' => 'De mercancías', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6210', 'puc_descripcion' => 'De materias primas', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6215', 'puc_descripcion' => 'De materiales indirectos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6220', 'puc_descripcion' => 'Compra de energía', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '6225', 'puc_descripcion' => 'Devoluciones en compras (CR)', 'puc_naturaleza' => 'Deudora'],
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
        
        $this->command->info('PUC Seeder for CostosDeVenta (Class 6) ran successfully!');
    }
}
