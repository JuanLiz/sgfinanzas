<?php

namespace Database\Seeders;

use App\Models\PUC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PUCPasivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasPUC = [
            ['puc_codigo' => '2105', 'puc_descripcion' => 'Bancos nacionales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2110', 'puc_descripcion' => 'Bancos del exterior', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2115', 'puc_descripcion' => 'Corporaciones financieras', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2120', 'puc_descripcion' => 'Compañías de financiamiento comercial', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2125', 'puc_descripcion' => 'Corporaciones de ahorro y vivienda', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2130', 'puc_descripcion' => 'Entidades financieras del exterior', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2135', 'puc_descripcion' => 'Compromisos de recompra de inversiones negociadas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2140', 'puc_descripcion' => 'Compromisos de recompra de cartera negociada', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2145', 'puc_descripcion' => 'Obligaciones gubernamentales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2195', 'puc_descripcion' => 'Otras obligaciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2205', 'puc_descripcion' => 'Nacionales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2210', 'puc_descripcion' => 'Del exterior', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2215', 'puc_descripcion' => 'Cuentas corrientes comerciales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2220', 'puc_descripcion' => 'Casa matriz', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2225', 'puc_descripcion' => 'Compañías vinculadas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2305', 'puc_descripcion' => 'Cuentas corrientes comerciales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2310', 'puc_descripcion' => 'A casa matriz', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2315', 'puc_descripcion' => 'A compañías vinculadas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2320', 'puc_descripcion' => 'A contratistas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2330', 'puc_descripcion' => 'Órdenes de compra por utilizar', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2335', 'puc_descripcion' => 'Costos y gastos por pagar', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2340', 'puc_descripcion' => 'Instalamentos por pagar', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2345', 'puc_descripcion' => 'Acreedores oficiales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2350', 'puc_descripcion' => 'Regalías por pagar', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2355', 'puc_descripcion' => 'Deudas con accionistas o socios', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2357', 'puc_descripcion' => 'Deudas con directores', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2360', 'puc_descripcion' => 'Dividendos o participaciones por pagar', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2365', 'puc_descripcion' => 'Retención en la fuente', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2367', 'puc_descripcion' => 'Impuesto a las ventas retenido', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2368', 'puc_descripcion' => 'Impuesto de industria y comercio retenido', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2370', 'puc_descripcion' => 'Retenciones y aportes de nómina', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2375', 'puc_descripcion' => 'Cuotas por devolver', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2380', 'puc_descripcion' => 'Acreedores varios', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2404', 'puc_descripcion' => 'De renta y complementarios', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2408', 'puc_descripcion' => 'Impuesto sobre las ventas por pagar', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2412', 'puc_descripcion' => 'De industria y comercio', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2416', 'puc_descripcion' => 'A la propiedad raíz', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2420', 'puc_descripcion' => 'Derechos sobre instrumentos públicos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2424', 'puc_descripcion' => 'De valorización', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2428', 'puc_descripcion' => 'De turismo', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2432', 'puc_descripcion' => 'Tasa por utilización de puertos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2436', 'puc_descripcion' => 'De vehículos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2440', 'puc_descripcion' => 'De espectáculos públicos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2444', 'puc_descripcion' => 'De hidrocarburos y minas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2448', 'puc_descripcion' => 'Regalías e impuestos a la pequeña y mediana minería', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2452', 'puc_descripcion' => 'A las exportaciones cafeteras', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2456', 'puc_descripcion' => 'A las importaciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2460', 'puc_descripcion' => 'Cuotas de fomento', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2464', 'puc_descripcion' => 'De licores, cervezas y cigarrillos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2468', 'puc_descripcion' => 'Al sacrificio de ganado', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2472', 'puc_descripcion' => 'Al azar y juegos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2476', 'puc_descripcion' => 'Gravámenes y regalías por utilización del suelo', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2495', 'puc_descripcion' => 'Otros', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2505', 'puc_descripcion' => 'Salarios por pagar', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2510', 'puc_descripcion' => 'Cesantías consolidadas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2515', 'puc_descripcion' => 'Intereses sobre cesantías', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2520', 'puc_descripcion' => 'Prima de servicios', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2525', 'puc_descripcion' => 'Vacaciones consolidadas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2530', 'puc_descripcion' => 'Prestaciones extralegales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2532', 'puc_descripcion' => 'Pensiones por pagar', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2535', 'puc_descripcion' => 'Cuotas partes pensiones de jubilación', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2540', 'puc_descripcion' => 'Indemnizaciones laborales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2605', 'puc_descripcion' => 'Para costos y gastos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2610', 'puc_descripcion' => 'Para obligaciones laborales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2615', 'puc_descripcion' => 'Para obligaciones fiscales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2620', 'puc_descripcion' => 'Pensiones de jubilación', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2625', 'puc_descripcion' => 'Para obras de urbanismo', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2630', 'puc_descripcion' => 'Para mantenimiento y reparaciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2635', 'puc_descripcion' => 'Para contingencias', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2640', 'puc_descripcion' => 'Para obligaciones de garantías', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2695', 'puc_descripcion' => 'Provisiones diversas', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2705', 'puc_descripcion' => 'Ingresos recibidos por anticipado', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2710', 'puc_descripcion' => 'Abonos diferidos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2715', 'puc_descripcion' => 'Utilidad diferida en ventas a plazos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2720', 'puc_descripcion' => 'Crédito por corrección monetaria diferida', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2725', 'puc_descripcion' => 'Impuestos diferidos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2805', 'puc_descripcion' => 'Anticipos y avances recibidos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2810', 'puc_descripcion' => 'Depósitos recibidos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2815', 'puc_descripcion' => 'Ingresos recibidos para terceros', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2820', 'puc_descripcion' => 'Cuentas de operación conjunta', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2825', 'puc_descripcion' => 'Retenciones a terceros sobre contratos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2830', 'puc_descripcion' => 'Embargos judiciales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2835', 'puc_descripcion' => 'Acreedores del sistema', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2840', 'puc_descripcion' => 'Cuentas en participación', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2895', 'puc_descripcion' => 'Diversos', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2905', 'puc_descripcion' => 'Bonos en circulación', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2910', 'puc_descripcion' => 'Bonos obligatoriamente convertibles en acciones', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2915', 'puc_descripcion' => 'Papeles comerciales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2920', 'puc_descripcion' => 'Bonos pensionales', 'puc_naturaleza' => 'Acreedora'],
            ['puc_codigo' => '2925', 'puc_descripcion' => 'Títulos pensionales', 'puc_naturaleza' => 'Acreedora'],
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
        
        $this->command->info('PUC Seeder for Pasivo (Class 2) ran successfully!');
    }
}
